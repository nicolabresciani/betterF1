docker run --name myXampp -p 41061:22 -p 41062:80 -d -v /workspaces/betterF1:/www tomsik68/xampp:8
<?php
    phpinfo();
?>