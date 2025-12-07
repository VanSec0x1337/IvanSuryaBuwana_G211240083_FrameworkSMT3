<?php
// This script was a GD-based logo generator but contained unsupported GD calls
// and is not used by the application. It has been disabled to avoid runtime
// errors. If you need a logo, please use the static image at
// public/images/LOGO-USMJAYA.png

http_response_code(410);
header('Content-Type: text/plain; charset=utf-8');
echo "This script has been removed. Use public/images/LOGO-USMJAYA.png instead.";
exit;

