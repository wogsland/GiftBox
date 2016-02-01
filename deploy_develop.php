<?php
echo 'preparing to deploy';
if (ENVIRONMENT == 'development') {
    passthru(__DIR__.'/deploy.sh');
}
