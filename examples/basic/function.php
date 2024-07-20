<?php

declare(strict_types=1);

use IfCastle\TypeDefinitions\FromEnv;

interface UserProfileInterface
{

}

interface ReturnInterface
{

}

class SomeParameter
{

}

class ReturnClass implements ReturnInterface
{

}

function test(SomeParameter $parameter, #[FromEnv] UserProfileInterface $userProfile): ReturnInterface
{
    return new ReturnClass();
}
