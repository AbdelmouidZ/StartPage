
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['speed_test'])) {
    while (ob_get_level()) ob_end_clean();
    header('Content-Type: application/octet-stream');
    header('Cache-Control: no-store, no-cache');
    header('Content-Encoding: identity');
    header('X-Accel-Buffering: no');

    set_time_limit(30);
    $chunk = random_bytes(1024 * 1024);

    for ($i = 0; $i < 100; $i++) {
        echo $chunk;
        flush();
        if (connection_aborted()) break;
    }
    exit;
}
?>

<div id="speed-box">
    <small>INTERNET SPEED</small>
    <strong id="speed-current">0.0 Mbps</strong>
    <div>Maximum: <b id="speed-max">0.0 Mbps</b></div>
    <small id="speed-status">Testing...</small>
</div>

<style>

</style>

<script>
(async () => {
    const current = document.getElementById('speed-current');
    const maximum = document.getElementById('speed-max');
    const status = document.getElementById('speed-status');

    let bytes = 0, max = 0;
    let running = true;
    const controllers = [];

    async function download() {
        while (running) {
            const controller = new AbortController();
            controllers.push(controller);

            try {
                const response = await fetch(location.href, {
                    method: 'POST',
                    body: new URLSearchParams({speed_test: '1'}),
                    cache: 'no-store',
                    signal: controller.signal
                });

                if (!response.ok || !response.body)
                    throw Error('Connection failed');

                const reader = response.body.getReader();

                while (running) {
                    const {done, value} = await reader.read();
                    if (done) break;
                    bytes += value.byteLength;
                }
            } catch {
                if (running) status.textContent = 'Connection error';
            } finally {
                controllers.splice(controllers.indexOf(controller), 1);
            }
        }
    }

    let last = performance.now();

    setInterval(() => {
        const now = performance.now();
        const mbps = bytes * 8 / ((now - last) * 1000);

        max = Math.max(max, mbps);
        current.textContent = mbps.toFixed(1) + ' Mbps';
        maximum.textContent = max.toFixed(1) + ' Mbps';

        if (bytes > 0) status.textContent = '● Live download';

        bytes = 0;
        last = now;
    }, 1000);

    for (let i = 0; i < 4; i++) download();

    window.addEventListener('pagehide', () => {
        running = false;
        controllers.forEach(c => c.abort());
    });
})();
</script>