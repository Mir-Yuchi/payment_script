<?php

file_put_contents("post.txt", file_get_contents('php://input').json_encode($_POST).json_encode($_REQUEST).'  abc');