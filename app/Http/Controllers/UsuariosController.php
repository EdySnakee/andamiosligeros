<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\LoginLog;
use Illuminate\Pagination\Paginator;

class UsuariosController extends Controller
{
    private $max_row;

    public function __construct()
    {
        $this->max_row = 10;
        $this->middleware('auth');
    }

    /**
     * Asegura que el usuario autenticado sea administrador.
     */
    private function asegurarAdmin()
    {
        if (!\Auth::check() || !\Auth::user()->isAdmin()) {
            abort(403, 'Acceso restringido: Solo los administradores pueden gestionar usuarios.');
        }
    }

    /**
     * Vista principal del catálogo de usuarios.
     */
    public function verUsuarios()
    {
        $this->asegurarAdmin();

        $roles_disponibles = User::getRolesDisponibles();
        $listado_usuarios = User::orderBy('id', 'desc')->paginate($this->max_row);

        return view('app_redes/modulos/usuarios/usuarios', compact('listado_usuarios', 'roles_disponibles'));
    }

    /**
     * Vista del registro de accesos/login de usuarios.
     */
    public function verRegistrosUsuarios()
    {
        $this->asegurarAdmin();

        $logs = LoginLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($this->max_row);

        return view('app_redes/modulos/usuarios/registro_usuarios/registros_usuarios', compact('logs'));
    }

    /**
     * Controlador de peticiones AJAX para usuarios.
     */
    public function ajax_usuarios(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Petición no permitida.'], 400);
        }

        if (!\Auth::check() || !\Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos de Administrador para realizar esta acción.'
            ], 403);
        }

        $accion = $request->input('accion');
        $datos = $request->input('datos', []);
        if (is_string($datos)) {
            $datos = json_decode($datos, true) ?: [];
        } elseif (is_object($datos)) {
            $datos = json_decode(json_encode($datos), true) ?: [];
        }

        switch ($accion) {
            case 'openModalUser':
                $accion_usr = $datos['accion_usr'] ?? 'agregar';
                $roles_disponibles = User::getRolesDisponibles();

                if (strtolower($accion_usr) === 'agregar') {
                    $accion = 'agregar';
                    $objUsuarios = new User();
                    $objUsuarios->id = 0;
                    $objUsuarios->name = '';
                    $objUsuarios->email = '';
                    $objUsuarios->tipo_usuario = User::ROL_VENDEDOR;
                    $objUsuarios->estatus = 1;
                } else {
                    $accion = 'Editar';
                    $id = $datos['id_usuario'] ?? $datos['id_usurio'] ?? null;
                    $objUsuarios = User::find($id);

                    if (!$objUsuarios) {
                        return response('<div class="alert alert-danger m-3">Usuario no encontrado.</div>', 404);
                    }
                }

                return view('app_redes/modulos/usuarios/modal_usuarios', compact('accion', 'objUsuarios', 'roles_disponibles'));

            case 'addUser':
            case 'createUser':
                $nombre = trim($datos['nombre_usuario'] ?? '');
                $email = trim(strtolower($datos['email_usr'] ?? ''));
                $password = $datos['password'] ?? '';
                $tipo_usuario = $datos['tipo_usuario'] ?? User::ROL_VENDEDOR;

                if (empty($nombre)) {
                    return response()->json(['success' => false, 'message' => 'El nombre completo es obligatorio.']);
                }
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return response()->json(['success' => false, 'message' => 'Por favor introduce un correo electrónico válido.']);
                }
                if (User::where('email', $email)->exists()) {
                    return response()->json(['success' => false, 'message' => 'El correo electrónico ya se encuentra registrado por otro usuario.']);
                }
                if (empty($password) || strlen($password) < 6) {
                    return response()->json(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
                }

                $roles_permitidos = array_keys(User::getRolesDisponibles());
                if (!in_array($tipo_usuario, $roles_permitidos)) {
                    $tipo_usuario = User::ROL_VENDEDOR;
                }

                $nuevo = new User();
                $nuevo->name = $nombre;
                $nuevo->email = $email;
                $nuevo->password = bcrypt($password);
                $nuevo->tipo_usuario = $tipo_usuario;
                $nuevo->estatus = 1;
                $nuevo->save();

                return response()->json(['success' => true, 'message' => 'Usuario creado exitosamente.']);

            case 'editUser':
                $id = $datos['id_usuario'] ?? null;
                $user = User::find($id);

                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'Usuario no encontrado.']);
                }

                $nombre = trim($datos['nombre_usuario'] ?? '');
                $email = trim(strtolower($datos['email_usr'] ?? ''));
                $password = $datos['password'] ?? null;
                $tipo_usuario = $datos['tipo_usuario'] ?? null;

                if (empty($nombre)) {
                    return response()->json(['success' => false, 'message' => 'El nombre completo es obligatorio.']);
                }
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return response()->json(['success' => false, 'message' => 'Por favor introduce un correo electrónico válido.']);
                }
                if (User::where('email', $email)->where('id', '!=', $user->id)->exists()) {
                    return response()->json(['success' => false, 'message' => 'El correo electrónico ya pertenece a otro usuario.']);
                }
                if (!empty($password) && strlen($password) < 6) {
                    return response()->json(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
                }

                $user->name = $nombre;
                $user->email = $email;

                // Solo actualizar contraseña si se proporcionó una nueva
                if (!empty($password)) {
                    $user->password = bcrypt($password);
                }

                if (!empty($tipo_usuario)) {
                    $roles_permitidos = array_keys(User::getRolesDisponibles());
                    if (in_array($tipo_usuario, $roles_permitidos) || in_array($tipo_usuario, ['admin', 'v1', 't1', 'vendedor', 'taller'])) {
                        $user->tipo_usuario = $tipo_usuario;
                    }
                }

                $user->save();

                return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente.']);

            case 'ConfirmDesactiva':
                $id = $datos['num_usuario'] ?? $datos['id_usuario'] ?? null;

                if ($id == \Auth::id()) {
                    return response()->json(['success' => false, 'message' => 'No puedes desactivar tu propia cuenta activa.']);
                }

                $user = User::find($id);
                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'Usuario no encontrado.']);
                }

                $user->estatus = 0;
                $user->save();

                return response()->json(['success' => true, 'message' => 'Usuario desactivado correctamente.']);

            case 'ConfirmActiva':
                $id = $datos['num_usuario'] ?? $datos['id_usuario'] ?? null;
                $user = User::find($id);

                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'Usuario no encontrado.']);
                }

                $user->estatus = 1;
                $user->save();

                return response()->json(['success' => true, 'message' => 'Usuario activado correctamente.']);

            case 'ConfirmElimina':
                $id = $datos['num_usuario'] ?? $datos['id_usuario'] ?? null;

                if ($id == \Auth::id()) {
                    return response()->json(['success' => false, 'message' => 'No puedes eliminar tu propia cuenta de Administrador.']);
                }

                $user = User::find($id);
                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'Usuario no encontrado.']);
                }

                $user->delete();

                return response()->json(['success' => true, 'message' => 'Usuario eliminado permanentemente.']);

            case 'getTablaUsuarios':
                $query = User::query();

                // Filtro por término de búsqueda (nombre, email o ID)
                $buscar = trim($datos['buscar'] ?? '');
                if (!empty($buscar)) {
                    $query->where(function ($q) use ($buscar) {
                        $q->where('name', 'like', "%{$buscar}%")
                          ->orWhere('email', 'like', "%{$buscar}%")
                          ->orWhere('id', $buscar);
                    });
                }

                // Filtro por rol
                $rol = $datos['rol'] ?? '';
                if (!empty($rol) && $rol !== 'todos') {
                    if ($rol === 'v1' || $rol === 'vendedor') {
                        $query->whereIn('tipo_usuario', ['v1', 'vendedor', 'f1', 'n2']);
                    } elseif ($rol === 't1' || $rol === 'taller') {
                        $query->whereIn('tipo_usuario', ['t1', 'taller']);
                    } else {
                        $query->where('tipo_usuario', $rol);
                    }
                }

                // Filtro por estatus
                $estatus = $datos['estatus'] ?? '';
                if ($estatus !== '' && $estatus !== 'todos') {
                    $query->where('estatus', (int)$estatus);
                }

                // Cantidad de registros por página
                $max_row = !empty($datos['max_row']) ? (int)$datos['max_row'] : $this->max_row;
                $max_row = in_array($max_row, [10, 25, 50, 100, 200]) ? $max_row : 10;

                // Resolver número de página para AJAX
                $page = (int)($request->input('page') ?: ($datos['page'] ?? 1));
                Paginator::currentPageResolver(function () use ($page) {
                    return $page > 0 ? $page : 1;
                });

                $listado_usuarios = $query->orderBy('id', 'desc')->paginate($max_row);

                return view('app_redes/modulos/usuarios/tabla_listado_usuarios', compact('listado_usuarios'));

            default:
                return response()->json(['success' => false, 'message' => 'Acción no reconocida.'], 400);
        }
    }
}

