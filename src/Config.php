<?php
namespace GiveToken;

class Config
{
    private static $instance = null;
	public $server = null;
    public $google_app_engine = false;
    public $application_id = null;
    public $prefix = "http://";
    public $use_https = false;
    public $app_root = "/";
    public $socket = null;
    public $stripe_secret_key = 'sk_test_RTcVNjcQVfYNiPCiY5O9CevV';
    public $stripe_publishable_key = 'pk_test_Gawg5LhHJ934MPXlvglZrdnL';
    public $database = "giftbox";
    public $user = "giftbox";
    public $password = "giftbox";
    public $app_name = "GiveToken";
    public $app_url = null;
    public $sender_email = "founder@givetoken.com";
    public $message_recipient_email = "founder@givetoken.com";
    public $development = true;
    public $file_storage_path = 'uploads/';

	private function __construct() {
        $this->server = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null;
        $this->development = ($this->server != 'www.givetoken.com');

        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] === "on") {
                $this->prefix = "https://";
                $this->use_https = true;
            }
        }

        if (isset($_SERVER["HTTP_X_APPENGINE_COUNTRY"])) {
            $this->application_id = $_SERVER["APPLICATION_ID"];
            $this->google_app_engine = true;
            if ($this->application_id === "s~stone-timing-557") {
                $this->file_storage_path = 'gs://tokenstorage/';
                $this->socket = '/cloudsql/stone-timing-557:test';
                $this->stripe_secret_key = 'sk_live_MuUj2k3WOTpvIgw8oIHaON2X';
                $this->stripe_publishable_key = 'pk_live_AbtrrWvSZZCvLYdiLohHC2Kz';
            } elseif ($application_id === "s~t-sunlight-757") {
                $this->file_storage_path = 'gs://tokenstorage-staging/';
                $this->socket = '/cloudsql/t-sunlight-757:staging';
            } else {
                $this->file_storage_path = 'gs://tokenstorage/';
            }
        }
        $this->app_url = $this->prefix.$this->server.$this->app_root;
	}

	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}
