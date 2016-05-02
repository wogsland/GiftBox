<?php
if (ENVIRONMENT == 'development') {
    execute_query("UPDATE `deploy` SET `needed`='Yes' WHERE `branch`='develop'");
}
