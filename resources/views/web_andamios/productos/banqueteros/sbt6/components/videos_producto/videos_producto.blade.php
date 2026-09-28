<section class="producto-video">
    <div class="container">
        <div class="text-center" style="margin: 40px 0px;">
            <a class="hero-btn" href="{{ url('/promociones/promocion-plataforma-gratis-en-la-compra-de-tu-andamio') }}">
                COMPRAR AHORA</a>
        </div>

        <div class="row">
            <!-- Video 1 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-7.jpg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-v-07.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-8.jpg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-v-08.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-9.jpg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-v-09.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Video 4 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-5.jpeg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-01.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Video 5 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-2.jpeg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-v-02.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Video 6 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-6.jpeg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-v-03.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Video 7 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-5.jpeg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-v-04.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Video 8 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-4.jpeg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-v-05.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Video 9 -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="ratio ratio-9x16 shadow rounded overflow-hidden">
                    <video controls playsinline preload="none"
                        poster="/web/img/andamios/SBT-6/portadas_videos/port-1.jpeg" class="lazy-video w-100 h-100">
                        <source data-src="/web/img/andamios/SBT-6/videos/vid-v-06.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>
</section>



<style>
    /* Relación vertical 9:16 */
    .ratio-9x16 {
        position: relative;
        width: 100%;
        padding-top: 177.77%;
    }

    .ratio-9x16>video,
    .ratio-9x16>iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 0;
    }
</style>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lazyVideos = [].slice.call(document.querySelectorAll("video.lazy-video"));

        if ("IntersectionObserver" in window) {
            let lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(videoEntry) {
                    if (videoEntry.isIntersecting) {
                        let video = videoEntry.target;
                        for (let source in video.children) {
                            let videoSource = video.children[source];
                            if (videoSource.tagName === "SOURCE") {
                                videoSource.src = videoSource.dataset.src;
                            }
                        }
                        video.load();
                        video.classList.remove("lazy-video");
                        lazyVideoObserver.unobserve(video);
                    }
                });
            });

            lazyVideos.forEach(function(lazyVideo) {
                lazyVideoObserver.observe(lazyVideo);
            });
        }
    });
</script>