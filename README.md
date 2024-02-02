# Monitor Laravel Apps in Production

<p align="center"><a href="https://moonguard.dev/filament-plugin" target="_blank"><img src="https://github.com/taecontrol/moonguard/assets/61505019/e66303aa-092b-4ca0-a7d7-cc573fe7fb55?raw=true" class="filament-hidden" alt="MoonGuard Filament Plugin Image"></a></p>

[![Latest Version](https://img.shields.io/github/release/taecontrol/moonguard.svg?style=flat-square)](https://github.com/taecontrol/moonguard/releases)
[![run-tests](https://github.com/taecontrol/moonguard/actions/workflows/run-tests.yml/badge.svg)](https://github.com/taecontrol/moonguard/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/taecontrol/moonguard.svg?style=flat-square)](https://packagist.org/packages/taecontrol/moonguard)

## About MoonGuard Filament Plugin

Your server can become overloaded, the application can crash, errors can occur, all without your notice. Our open-source tool is designed to ensure maximum performance and availability of your Laravel Apps in production.

MoonGuard is a Filament plugin that helps you to monitor multiple Laravel Apps simultaneously, validate their proper functioning, oversee their real-time performance, and notify you of any changes detected in any of them. It offers you the flexibility to customize it according to your needs.

<p align="center"><a href="https://moonguard.dev/filament-plugin" target="_blank"><img src="https://github.com/taecontrol/moonguard/assets/61505019/28009a81-da97-47e7-a1bc-03a37bb25eaf" alt="MoonGuard Demo"></a></p>

Check the MoonGuard Filament Plugin demo [here](https://moonguard.dev/filament-plugin).

## How MoonGuard Filament Plugin works

This plugin offers comprehensive monitoring for multiple Laravel Apps simultaneously. It vigilantly tracks site uptime and keeps a close watch on SSL certificate validity. In addition, it logs any exceptions or errors that arise on your App. To ensure you're always in the loop, the plugin promptly sends alerts through email or Slack when specific conditions are met, such as a Laravel App experiencing downtime.

If you want to get detailed information about the status of your servers, including CPU load, RAM usage, and disk space, or catch exceptions from your applications, you must integrate [Larvis](https://github.com/taecontrol/larvis) into your project. Larvis is a lightweight package that is part of the MoonGuard ecosystem. Its installation is straightforward: once added to your project, you just need to configure it to send data to your MoonGuard system via HTTP requests. Furthermore, Larvis has the versatility to communicate with both the MoonGuard Filament Plugin and the [Krater](https://moonguard.dev/krater) desktop application.

But what is Krater? It's a desktop application designed for developers working with Laravel. It offers an advanced debugging tool that allows users to examine and analyze their applications locally.

## From Idea to Launch: MoonGuard Filament Plugin Book

You have the opportunity to create your very own Laravel package from scratch. To guide you through this creative journey, our team has written a comprehensive book just for you. It outlines the entire process of conception, development, and launch of the MoonGuard Filament Plugin, step by step. The best part? This book is completely free, and you can obtain your own digital copy [here](https://moonguard.dev/book).

Titled "MoonGuard: The Software Creator's Journey," the purpose of the book is to illustrate the package-building process with specific code examples that provide context to understand each decision we made while designing the Moonguard Filament Plugin. Let this book be the springboard for your very own package-creating adventure!

## Documentation

You can find the whole guide, configuration and setup in our [documentation site](https://docs.moonguard.dev).

## Testing

```bash
composer test
```

## Krater: Debugging Evolved

<p align="center"><a href="https://moonguard.dev/krater" target="_blank"><img src="https://github.com/taecontrol/moonguard/assets/61505019/63c0ca3d-6a91-4c50-a399-a804cdaf71f0" alt="MoonGuard: Krater Image"></a></p>

Krater is a lightweight, cross-platform application that revolutionizes Laravel app debugging on your next major project.

## MoonGuard: The Software Creator's Journey [Book]

The MoonGuard development team has written a book named "MoonGuard: The Software Creator's Journey." In this book, we document and explain the entire process of creating, developing, publishing MoonGuard as a Filament Plugin. Every hard corner and special tricks were registered on this book, you can obtain your own digital copy [here](https://moonguard.dev/book).

<p align="center"><a href="https://moonguard.dev/book" target="_blank"><img src="https://github.com/taecontrol/moonguard/assets/61505019/ecae1c7a-9602-4c43-8ee0-ac684bd636b1" alt="MoonGuard: Book"></a></p>

## Contributing

We appreciate your interest in MoongGuard and we welcome your contributions. To help you get started, we have prepared a contribution guide that you can access from the [MoonGuard documentation](https://docs.moonguard.dev/contributions). If you have any questions or feedback, feel free to join our [Discord](https://discord.com/invite/vCCy4aJxnY) server and chat with us.

## License

The Moonguard Filament Plugin is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
