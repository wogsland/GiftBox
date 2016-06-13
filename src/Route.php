<?php
namespace Sizzle;

use Sizzle\Bacon\Database\{
    RecruitingToken,
    WebRequest
};

/**
 * This class is for routing URI requests
 */
class Route
{
    protected $default;
    protected $endpointPieces;
    protected $endpointMap;
    protected $gets;
    protected $webRequestId;

    /**
     * Includes appropriate file based on the provided endpoint pieces
     *
     * @param array $endpointPieces - the parsed pieces of the endpoint
     * @param array $gets           - associative array of GET variables
     * @param array $webRequestId   - associative array of GET variables
     */
    public function __construct(array $endpointPieces, array $gets = array(), int $webRequestId = null)
    {
        $this->endpointPieces = $endpointPieces;
        $this->gets = $gets;
        $this->webRequestId = $webRequestId;
        $this->default = __DIR__.'/../error.php';
    }

    /**
     * Includes appropriate file based on the provided endpoint pieces
     *
       PLEASE ADD A TEST TO src/RoutingTest.php FOR EACH ENDPOINT ADDED HERE
     */
    public function go()
    {
        if (!isset($this->endpointPieces[1])) {
            include __DIR__.'/../lp/startuply.php';
        } else {
            switch ($this->endpointPieces[1]) {
            case '':
            case 'index.html':
                include __DIR__.'/../lp/startuply.php';
                break;
            case 'about':
                include __DIR__.'/../about.php';
                break;
            case 'affiliates':
                include __DIR__.'/../affiliates.php';
                break;
            case 'affiliate':
            case 'affiliate-program':
            case 'affiliateprogram':
                header('Location: /affiliates', true, 301);
                break;
            case 'attribution':
                include __DIR__.'/../attribution.php';
                break;
            case 'activate':
                include __DIR__.'/../activate.php';
                break;
            case 'ajax':
                include __DIR__.'/../ajax/route.php';
                break;
            case 'api_documentation':
                include __DIR__.'/../api_documentation.php';
                break;
            case 'careers':
                include __DIR__.'/../careers.php';
                break;
            case 'create_company':
                include __DIR__.'/../create_company.php';
                break;
            case 'create_recruiting':
                include __DIR__.'/../create_recruiting.php';
                break;
            case 'email_credentials':
                include __DIR__.'/../email_credentials.php';
                break;
            case 'email_list':
                include __DIR__.'/../email_list.php';
                break;
            case 'email_signup':
                include __DIR__.'/../lp/email_signup.php';
                break;
            case 'free_trial':
                include __DIR__.'/../lp/free-trial.php';
                break;
            case 'forgot_password':
                include __DIR__.'/../forgot_password.php';
                break;
            case 'invoice':
                include __DIR__.'/../invoice.php';
                break;
            case 'iframe_code':
                include __DIR__.'/../iframe_code.php';
                break;
            case 'job_listing':
                include __DIR__.'/../job_listing.php';
                break;
            case 'js':
                if (!isset($this->endpointPieces[2]) || '' == $this->endpointPieces[2]) {
                    include $this->default;
                /* EXPERIMENT 1 */
                } elseif (
                'dist' == $this->endpointPieces[2]
                && 'recruiting_token.min.js' == $this->endpointPieces[3]
                && isset($this->gets['t'])
                ) {
                    $filename = __DIR__.'/../token/'.$this->gets['t'].'/recruiting_token.min.js';
                    if (file_exists($filename)) {
                        include $filename;

                        //mark the web request
                        $webRequest = new WebRequest($this->webRequestId);
                        $webRequest->inExperiment(
                            (int) substr($this->gets['t'], 0, 1),
                            substr($this->gets['t'], 1)
                        );
                    } else {
                        include $this->default;
                    }
                /* END EXPERIMENT 1 */
                } else {
                    switch ($this->endpointPieces[2]) {
                    default:
                        include $this->default;
                    }
                }
                break;
            case 'mascot':
                include __DIR__.'/../mascot.php';
                break;
            case 'password_reset':
                include __DIR__.'/../password_reset.php';
                break;
            case 'payments':
                include __DIR__.'/../payments.php';
                break;
            case 'pricing':
                include __DIR__.'/../pricing.php';
                break;
            case 'privacy':
                include __DIR__.'/../privacypolicy.php';
                break;
            case 'profile':
                include __DIR__.'/../profile.php';
                break;
            case 'recruiting_made_easy':
                include __DIR__.'/../lp/bc1.php';
                break;
            case 'robots.txt':
                if (ENVIRONMENT != 'production') {
                    echo "User-agent: *\n";
                    echo "Disallow: /\n";
                }
                break;
            case 'support':
                include __DIR__.'/../support.php';
                break;
            case 'teapot':
                include __DIR__.'/../teapot.php';
                break;
            case 'send_recruiting':
                include __DIR__.'/../send_recruiting.php';
                break;
            case 'terms':
                include __DIR__.'/../termsservice.php';
                break;
            case 'thankyou':
                include __DIR__.'/../thankyou.php';
                break;
            case 'token':
                $long_id = isset($this->endpointPieces[3]) ? trim($this->endpointPieces[3], '/') : '';
                include $this->getTokenFile();
                break;
            case 'tokens':
                include __DIR__.'/../tokens.php';
                break;
            case 'token_responses':
                include __DIR__.'/../token_responses.php';
                break;
            case 'track':
                include __DIR__.'/../track.php';
                break;
            case 'upload':
                include __DIR__.'/../upload.php';
                break;
            case 'test':
                // this endpoint is just for non-production testing
                if (ENVIRONMENT != 'production') {
                    include __DIR__.'/../lp/sizzle1.php';
                    break;
                }
            case 'zdrip':
                // this endpoint is just for non-production testing
                if (ENVIRONMENT != 'production') {
                    include __DIR__.'/../deploy_develop.php';
                    break;
                }
            default:
                include $this->default;
            }
        }
    }

    /**
     * Register an endpoint for routing.
     *
     * @param string $endpoint   - the URI endpoint to process
     * @param string $fileToLoad - file to load for that endpoint
     *
     * @return boolean - was registration successful
     */
    public function register($endpoint, $fileToLoad)
    {
        $endpoint = ltrim($endpoint, '/');
        $endpointParts = explode('/', $endpoint);
        switch (count($endpointParts)) {
        case 0:
            $this->endpointMap[''] = $fileToLoad;
            break;
        case 1:
            $this->endpointMap[$endpointParts[0]] = $fileToLoad;
            break;
        case 2:
            if (!isset($this->endpointMap[$endpointParts[0]])) {
                $this->endpointMap[$endpointParts[0]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]])) {
                    $temp = $this->endpointMap[$endpointParts[0]];
                    $this->endpointMap[$endpointParts[0]] = array();
                    $this->endpointMap[$endpointParts[0]][''] = $temp;
                }
            }
            $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = $fileToLoad;
            break;
        case 3:
            if (!isset($this->endpointMap[$endpointParts[0]])) {
                $this->endpointMap[$endpointParts[0]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]])) {
                    $temp = $this->endpointMap[$endpointParts[0]];
                    $this->endpointMap[$endpointParts[0]] = array();
                    $this->endpointMap[$endpointParts[0]][''] = $temp;
                }
            }
            if (!isset($this->endpointMap[$endpointParts[0]][$endpointParts[1]])) {
                $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]][$endpointParts[1]])) {
                    $temp = $this->endpointMap[$endpointParts[0]][$endpointParts[1]];
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = array();
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]][''] = $temp;
                }
            }
            $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]] = $fileToLoad;
            break;
        case 4:
            if (!isset($this->endpointMap[$endpointParts[0]])) {
                $this->endpointMap[$endpointParts[0]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]])) {
                    $temp = $this->endpointMap[$endpointParts[0]];
                    $this->endpointMap[$endpointParts[0]] = array();
                    $this->endpointMap[$endpointParts[0]][''] = $temp;
                }
            }
            if (!isset($this->endpointMap[$endpointParts[0]][$endpointParts[1]])) {
                $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]][$endpointParts[1]])) {
                    $temp = $this->endpointMap[$endpointParts[0]][$endpointParts[1]];
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = array();
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]][''] = $temp;
                }
            }
            if (!isset($this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]])) {
                $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]])) {
                    $temp = $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]];
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]] = array();
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]][''] = $temp;
                }
            }
            $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]][$endpointParts[3]] = $fileToLoad;
            break;
        }
    }

    /**
     * Gets the file to include for the token directory and all the complexity there around
     *
     * @return sting - filename to include
     */
    protected function getTokenFile()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        if (isset($this->endpointPieces[2],$this->endpointPieces[3]) && 'recruiting' == $this->endpointPieces[2]) {
            $detect = new \Mobile_Detect;
            if ($detect->isMobile()
                && strpos($userAgent, 'AppleWebKit') !== false
                && strpos($userAgent, 'Safari') === false
                && strpos($userAgent, 'Chrome') === false
                && strpos($userAgent, 'iPhone') === false
            ) {
                // don't display in native android browser
                return __DIR__.'/../get_chrome.html';
            } else if (strpos($userAgent, 'LinkedInBot') !== false) {
                // display simplified form on LinkedIn
                return __DIR__.'/../token/LinkedInBot.php';
            } else if (strpos($userAgent, 'facebookexternalhit') !== false) {
                // display simplified form on Facebook
                return __DIR__.'/../token/facebookexternalhit.php';
            } else {
                $webRequest = new WebRequest($this->webRequestId);

                /* EXPERIMENT 2 */
                $long_id = trim($this->endpointPieces[3], '/');
                $token = new RecruitingToken($long_id, 'long_id');
                if (isset($token->auto_popup)) {
                    $webRequest->inExperiment(
                        2,
                        ('N' == $token->auto_popup ? $token->auto_popup : (string) $token->auto_popup_delay)
                    );
                }
                /* END EXPERIMENT 2 */

                /* EXPERIMENT 1 */
                if (rand(1,100) > 50) {
                    //mark the web request
                    $webRequest->inExperiment(1, 'A');

                    return __DIR__.'/../token/1A/recruiting_token.build.html';
                } else {
                    //mark the web request
                    $webRequest->inExperiment(1, 'B');

                    return __DIR__.'/../token/1B/recruiting_token.build.html';
                }
                /* END EXPERIMENT 1 */
            }
        } else {
            return $this->default;
        }
    }
}
