<?php

namespace Taecontrol\Moonguard\Enums;

enum SslCertificateStatus: string
{
    case NOT_YET_CHECKED = 'not yet checked';

    case VALID = 'valid';

    case INVALID = 'invalid';
}
