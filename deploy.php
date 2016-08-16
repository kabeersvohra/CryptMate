<?php

if ($_POST["payload"])
{
    echo shell_exec("git reset --hard origin/dev && git pull origin dev");
}
