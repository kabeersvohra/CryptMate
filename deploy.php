<?php

if ($_POST["payload"])
    echo shell_exec("git reset --hard HEAD && git pull origin dev");