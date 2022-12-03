<?php

namespace Taecontrol\Larastats\Contracts;

interface LarastatsUser
{
    public function routeNotificationForSlack(): string;
}
