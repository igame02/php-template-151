<?php

namespace igame02\Service\Login;

interface LoginService
{
   public function authenticate($username, $password);
}
