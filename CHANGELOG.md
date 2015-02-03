# CHANGELOG

v2.0.0-dev

- Rely on composer for autoloading (PSR4) (possible BC)
- config key phingPath is now phingBin (possible BC)
- Depend on Symfony's Process component for running the Phing process, which will handle passing of environment values to the phing executable
- (BC) calling 'build' now returns an instance of Process

v1.0.1

- No public facing changes

v1.0.0

- First release

v1.0.0-beta3

- Updated to zf2 2.0.0+ ! BC Break by namespace and configuration changes!

v1.0.0-beta2

- 'Composerized', updated to zf2-beta-4

v1.0.0-beta1

- Initial pre-release
