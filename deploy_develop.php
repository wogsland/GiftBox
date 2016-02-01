<?php
if (ENVIRONMENT == 'development') {
    update("UPDATE `deploy` SET `needed`='Yes' WHERE `branch`='develop'");
}
