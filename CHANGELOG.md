# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-01-01

### Added
- Initial release of Getfreeproxy PHP SDK
- Semantic API client with fluent QueryBuilder pattern
- Support for filtering proxies by country, protocol, and page number
- Comprehensive exception hierarchy (ApiException, UnauthorizedException, InvalidParameterException)
- Proxy DTO model with 17 typed properties for type-safe response handling
- Full PHP 8.0+ type hints and strict typing
- PSR-4 autoloading with Composer
- Zero external dependencies (uses native cURL)
- Bearer token authentication support
- Example usage scripts and comprehensive README documentation
- GitHub Actions workflow for automatic Packagist publishing on release
- MIT License
