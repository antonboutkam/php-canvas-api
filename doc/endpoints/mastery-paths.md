# Mastery Paths

Canvas does not currently expose a full CRUD endpoint to configure mastery path rules themselves.
It does expose endpoints to read module-item sequencing state and to select an assignment set on mastery-path items.

## Supported Endpoints

### `GET /api/v1/courses/:course_id/module_item_sequence`

Use this endpoint to retrieve item sequence data for a specific asset and inspect mastery-path state.

Required query parameters:

- `asset_type` (for example `ModuleItem`)
- `asset_id`

Optional query parameters:

- `student_id`

SDK support:

- `Canvas::getModuleItemSequence(int $courseId, string $assetType, int|string $assetId, ?int $studentId = null): ModuleItemSequence`
- Command: `module-item-sequence:get <course_id> <asset_type> <asset_id> [student_id]`

### `POST /api/v1/courses/:course_id/modules/:module_id/items/:id/select_mastery_path`

Use this endpoint to choose one assignment set for a mastery-path module item.

Form parameters:

- `assignment_set_id` (required)
- `student_id` (optional, admin/teacher acting for a specific student)

SDK support:

- `Canvas::selectMasteryPath(int $courseId, int $moduleId, int $moduleItemId, string $assignmentSetId, ?int $studentId = null): array`
- Command: `mastery-path:select <course_id> <module_id> <module_item_id> <assignment_set_id> [student_id]`

## SDK Models Added

- `Hurah\Canvas\Endpoints\MasteryPath\MasteryPath`
- `Hurah\Canvas\Endpoints\ModuleItemSequence\ModuleItemSequence`
- `Hurah\Canvas\Endpoints\ModuleItemSequence\ModuleItemSequenceNode`

## Notes

- Mastery-path rule authoring is typically done through Canvas UI.
- Use module-item sequence + selection endpoints for API-driven workflows where you need to inspect or choose paths.
