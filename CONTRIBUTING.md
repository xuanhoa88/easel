# Easel Contribution Guide

Hi! I’m really excited that you are interested in contributing to Canvas. Before submitting your contribution though, please make sure to take a moment and read through the following guidelines.

## HipChat

Canvas has an official [HipChat group](https://canvas-chat.hipchat.com) to be used as an open forum for those who want to contribute and collaborate on the project. If you'd like to be added to the team, [contact me](mailto:austin.todd.j@gmail.com) and I'll get you set up! 

## Issue Reporting Guidelines

- Try to search for your issue, it may have already been answered or even fixed in the master branch.

- Check if the issue is reproducible with the latest stable version of Canvas. If you are using a previous version, please indicate the specific one you are using.

- It is **required** that you clearly describe the steps necessary to reproduce the issue you are running into. Issues with no clear reproduction steps cannot be assessed.

- If your issue is resolved but still open, don’t hesitate to close it. In case you found a solution by yourself, it could be helpful to explain how you fixed it.

## Pull Request Guidelines

- Keep the commit as small and modular as possible. If your pull request addresses more than one issue, create separate requests.

- Squash the commit if there are too many small ones.

- Make your commit message relevant and useful, referencing an issue or pull request as often as possible:
    - Bad commit message: `refactor`
    - Good commit message: `Refactor store method in PostController #63`

- Follow the [coding style](#coding-style).

- Make sure `phpunit` tests pass.

- If adding a new feature:
    - Add accompanying test case.
    - Provide convincing reason to add this feature.

- If fixing a bug:
    - Provide detailed description of the bug in the pull request.
    - Add appropriate test coverage if applicable.

## Coding Style

Canvas follows the [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard and the [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) autoloading standard.

## Continuous Integration

- Integration with [TravisCI](https://travis-ci.org) is crucial. Pull requests must pass this test before being reviewed to merge into the project.
- Don't worry if your code styling isn't perfect! [StyleCI](https://styleci.io/) will take care of any style inconsistencies after pull requests are merged. This allows us to focus on the content of the contribution and not the code style.
- Pull requests can still be merged if the [VersionEye](https://www.versioneye.com) check fails. This just helps us keep a closer eye on staying up to date with dependencies.

## Building the Easel

[How to build an Easel?](https://www.buildeazy.com/newplans/easel_4_06.html)