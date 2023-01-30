<?php

namespace App\Http\Middleware;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class JwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @return mixed
     */
    public function handle($host, $login)
    {
        $algorithm    = new Sha256();
        $signingKey   = InMemory::plainText(random_bytes(32));
        $builder = (new Builder)
            ->identifiedBy(mt_rand(0, 0x3fff))
            ->issuedBy($host)
            ->permittedFor($host)
            ->relatedTo($login);
        return (string) $builder->getToken($algorithm, $signingKey);
    }
}
