<div class="flex items-center justify-between">
    <span class="text-gray-500">Certificate</span>
    @if(! $site->sslCertificateCheck)
        <span class="text-gray-500">---</span>
    @elseif(! $site->sslCertificateCheck?->is_enabled || ! $site->ssl_certificate_check_enabled)
        <span class="text-gray-400">Disabled</span>
    @elseif($site->sslCertificateCheck->status === \Taecontrol\Larastats\Enums\SslCertificateStatus::NOT_YET_CHECKED)
        <span class="text-gray-500">---</span>
    @elseif($site->sslCertificateCheck->status === \Taecontrol\Larastats\Enums\SslCertificateStatus::VALID)
        <span class="text-green-500 text-sm font-bold">OK</span>
    @else
        <span class="text-red-500 text-sm uppercase font-bold">{{ $site->sslCertificateCheck->status->value }}</span>
    @endif
</div>
