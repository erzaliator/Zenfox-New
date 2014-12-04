<?php

class Player_FacebookoauthController extends Zend_Controller_Action {

    public function indexAction() {

        // first you should register your website and request a client_id and a
        // client_secret from Facebook to access their oauth2 server / api
        // here: http://developers.facebook.com/setup/
        $oauthOptions = array(
			// Facebook authorization endpoint
			'siteUrl' => 'https://graph.facebook.com/oauth/',
			// my callback url to which facebook will redirect users
			// after they accepted or denied the permissions request
			'callbackUrl' => 'http://zenfox.tld/oauth/callback/',
			// the client identifier you got from Facebbok
			'clientId' => '143168342410923',
			// the type of user delegation authorization flow
			'type' => 'web_server',
			// An opaque value used by the client to maintain state between
			// the request and callback
			'state' => '',
			// The parameter value must be set to "true" or "false"
			// (case sensitive).  If set to "true", the authorization
			// server MUST NOT prompt the end user to authenticate or
			// approve access
			'immediate' => '',
			// the extend permissions a want to get, a full list
			// of available permissions can be found here:
			// http://developers.facebook.com/docs/authentication/permissions
			'requestedRights' => array(
				'publish_stream',
				'offline_access',
				'read_stream',
				'user_about_me',
				'user_birthday',
				'user_likes',
				'user_location',
				'user_photos',
				'user_videos',
				'user_website',
				'read_friendlists'
			)
		);

        // OAuth 2.0 is a simpler version of OAuth that leverages SSL for API
        // communication instead of relying on complex URL signature schemes
        // and token exchanges.
        $oauth2 = new Zenfox_Oauth2_Oauth2($oauthOptions);

        // using OAuth 2.0 entails getting an access token for a Facebook user
        // via a redirect to Facebook
        $oauth2->authorizationRedirect();

    }

    public function callbackAction() {

        //Zend_Debug::dump($_GET);
        //Zend_Debug::dump($_POST);
        //Zend_Debug::dump($_REQUEST);

        // After the user authorizes your application, Facebook redirects the user
        // back to the redirect URI you specified with a verification string in
        // the argument code, which can be exchanged for an oauth access token
        $code = $this->_request->getParam('code', '');

        // In this example i put the token in the session, but you can / should put
        // the token in the database to retrieve it when you need it
       // $myTokenSessionNamespace = new Zend_Session_Namespace('facebookAccessToken');

        // check if the token is already in the session, if not (its the first time
        // this page is called) put it in the session
        //if (!isset($myTokenSessionNamespace->token)) {

            if (!empty($code)) {

                $verificationCode = trim(addslashes(strip_tags($code)));

                $oauthOptions = array(
                            // Facebook authorization endpoint
                            'siteUrl' => 'https://graph.facebook.com/oauth/',
                            // my callback url to which facebook will redirect users
                            // after they accepted or denied the permissions request
                            'callbackUrl' => 'http://zenfox.tld/oauth/callback/',
                            // the client identifier you got from Facebbok
                            'clientId' => '143168342410923',
                            // the client secret you got from Facebbok
                            'clientSecret' => '58b2057bac65d16f9856d8b498f67562',
                            'secret_type' => ''
                        );

                $oauth2 = new Zenfox_Oauth2_Oauth2($oauthOptions);

                $oauth2->setVerificationCode($verificationCode);

                $acessToken = $oauth2->requestAccessToken();

                Zenfox_Debug::dump($acessToken);
                //exit;

                //$myTokenSessionNamespace->token = $acessToken;

            } else {

                Zend_Debug::dump('verification code not found');

            }

     //   }

        //Zend_Debug::dump($myTokenSessionNamespace->token);
        //exit;

        // Now that we have an acces token we can use the access token returned
        // by the request above to make requests on behalf of the user, if you
        // request the extend permission "offline_access" as i did you can use
        // the access token to make graph requests even if the user is not online
        // anymore
        if (isset($acessToken)) {

            //Zend_Debug::dump($myTokenSessionNamespace->token);
            // 113659751999792|11cc94bbb7281711e91436e9-1183842635|7cL8SbgSj6OZ73WnXjBB26xE3ZM.

            $facebookOptions = array(
                                    'ConnectionsIntrospection' => false,
                                    'AppSecret' => '58b2057bac65d16f9856d8b498f67562',
                                    'AppId' => '143168342410923'
                                );

            $facebook = new Zenfox_Oauth2_Service_Facebook($facebookOptions);
            // instead of the name you can also pass the facebook id 1183842635
            // to get data about the current user you can use "me"
            $facebook->setObjectId('me');
            $facebook->setAccessToken($acessToken);

            // instead of setting the objectId and the accessToken you can also pass them as parameter
            //$response = $facebook->graphQuery('webchris', $myTokenSessionNamespace->token);
            //Zend_Debug::dump($response);

            // query webchris data
            $response = $facebook->graphQuery();
            Zend_Debug::dump($response);
            $fid = '100001559417241';
            ?>
            <html>
            <body>
            <img src="https://graph.facebook.com/<?= $fid ?>/picture"></img>
            </body>
            </html>
            <?php

            // just query one special connection from webchris
            //$response = $facebook->graphQuery(null, null, 'likes');
            //Zend_Debug::dump($response);

            // just query one special fields from webchris
            //$response = $facebook->graphQuery(null, null, null, 'name');
            //Zend_Debug::dump($response);

            // query multiple fields
            //$response = $facebook->graphQuery(null, null, null, array('first_name', 'last_name'));
            //Zend_Debug::dump($response);

            // query multiple fields and a connection
            //$response = $facebook->graphQuery(null, null, array('feed', 'likes'), array('first_name', 'last_name'));
            //Zend_Debug::dump($response);

            // to query "public" objects from graph you dont need an access token
            // thats why you can clear it
            //$facebook->clearAccessToken();
            //$response = $facebook->graphQuery('f8');
            //Zend_Debug::dump($response);

            // to get a list of connections an object has, you can enable the
            // connections introspection, its disbled by default
            //$facebook->clearAccessToken();
            //$facebook->setConnectionsIntropsection(true);
            //$response = $facebook->graphQuery('f8');
            //Zend_Debug::dump($response);

            // we can ask for a connections list, which we afterwards use to do
            // queries requesting all the informations from these connections
            // (if we have the persmissions we need to query those informations)
            //$facebook->setConnectionsIntropsection(true);
            //$facebook->setAccessToken($myTokenSessionNamespace->token);
            //$response = $facebook->graphQuery('webchris');
            //$connectionsList = array_flip($response['metadata']['connections']);
            //$response = $facebook->graphQuery('webchris', null, $connectionsList);
            //Zend_Debug::dump($response);

            // you can also limit the amount of results you get if you query connected
            // objects, if you add the limit parameter and if its smaller then the
            // maximum amount, Facebook will add a "paging" key which has the url
            // of the next (and previous) page, works with single and multiple
            // connections set, to select a specific page you can use the offset /
            // since / until parameters
            /*
            $facebook->setLimit(2);
            $response = $facebook->graphQuery('webchris', $myTokenSessionNamespace->token, 'feed');
            Zend_Debug::dump($response);
            $urlParts = parse_url($response['paging']['next']);
            $parameterPairs = explode('&', $urlParts['query']);
            foreach($parameterPairs as $parameterPair) {
                $parameterPairArray = explode('=', $parameterPair);
                if ($parameterPairArray[0] == 'until') $date = $parameterPairArray[1];
            }
            $facebook->setSince(rawurldecode($date));
            $response = $facebook->graphQuery('webchris', $myTokenSessionNamespace->token, 'feed');
            Zend_Debug::dump($response);
            $facebook->clearLimit();
            $facebook->clearSince();
            */

            //$facebook->setLimit(2);
            //$facebook->setOffset(6);
            //$response = $facebook->graphQuery('webchris', $myTokenSessionNamespace->token, 'likes');
            //Zend_Debug::dump($response);
            //$facebook->clearLimit();
            //$facebook->clearOffset();

            // search an individual user's News Feed, restricted to that
            // user's friends, if the users activity feed is not public you will
            // have to use the acces token
            //$facebook->setAccessToken($myTokenSessionNamespace->token);
            //$response = $facebook->searchGraphQuery('farmville');
            //Zend_Debug::dump($response);

            // Facebook search in user objects
            //$response = $facebook->searchGraphQuery('chris', 'user', $myTokenSessionNamespace->token); // offset
            //Zend_Debug::dump($response);

            // for the posts you dont need a token, even with a token it doesnt seem it finds no wall posts from users that have a private account
            //$response = $facebook->searchGraphQuery('Musica Nuda', 'post', $myTokenSessionNamespace->token); // since until
            //Zend_Debug::dump($response);

            // dont need a token for pages
            //$response = $facebook->searchGraphQuery('imail.lu', 'page'); // offset
            //Zend_Debug::dump($response);

            // you need a token for the pages
            //$response = $facebook->searchGraphQuery('seach_for_this', 'event'); // since until
            //Zend_Debug::dump($response);

            //$response = $facebook->searchGraphQuery('chris', 'group', $myTokenSessionNamespace->token);
            //Zend_Debug::dump($response);

            // do all objects not need acces token??
            // TODO: can we search friends feeds??
            // TODO: add since / until / offset?? param support

        } else {

            Zend_Debug::dump('access token not found');

        }

    }

}