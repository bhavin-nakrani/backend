<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FacebookController.
 *
 * @Route("/connect")
 */
class FacebookController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process.
     *
     * @Route("/facebook", name="connect_facebook_start")
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        // will redirect to Facebook!
        return $clientRegistry
            ->getClient('facebook_main') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([
                'public_profile', 'email', // the scopes you want to access
            ], []);
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml.
     *
     * @Route("/facebook/check", name="connect_facebook_check")
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient $client */
        $client = $clientRegistry->getClient('facebook_main');

        /*$options = [
            'redirect_uri' => "https://socialcrawler.bn/connect/facebook/check"
        ];
        $accessToken = $client->getAccessToken($options);
        if ($accessToken && !$accessToken->getToken()) {
            dump("User is not found!"); die;
        }
        $provider = $client->getOAuth2Provider();
        $longLivedToken = $provider->getLongLivedAccessToken($accessToken);
        //I get the user by using long lived token
        $facebookUser = $client->fetchUserFromToken($longLivedToken);
        var_dump($facebookUser);
        exit;*/
        try {
            // the exact class depends on which provider you're using
            /** @var \League\OAuth2\Client\Provider\FacebookUser $user */
            $user = $client->fetchUser();

            // do something with all this new power!
            // e.g. $name = $user->getFirstName();
            var_dump($user);
            die;
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage());
            die;
        }
    }
}
