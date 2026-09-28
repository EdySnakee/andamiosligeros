<?php


namespace App;


class CreatePostFileAction
{
    private $interventionSaveImageAction;

    public function __construct(InterventionSaveImageAction $interventionSaveImageAction)
    {
        $this->interventionSaveImageAction = $interventionSaveImageAction;
    }

    public function run($file, $width = 600)
    {
        $fileName = "storage/clientes/{$file->getClientOriginalName()}";

        $this->interventionSaveImageAction->run($file, $width, $fileName);

        return $fileName;
    }
}
