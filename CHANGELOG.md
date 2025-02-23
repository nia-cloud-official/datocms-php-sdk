## [1.0.1] - 23-02-2025

## Description
Fixes the "Unexpected parameter: []" error by ensuring empty GraphQL variables are sent as `{}` instead of `[]`.

## Changes
- Modified the `query()` method to cast empty `$variables` arrays to `stdClass` objects.
- Retains support for associative arrays when variables are provided.

## Fix
Variables Handling:** Empty variables are now serialized as `{}` (JSON object) instead of `[]` (array) to comply with DatoCMS API requirements.
