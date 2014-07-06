#Volleyball
##Summer Camp Scheduling System
###Organization Bundle

Council element for the Organization Bundle of the Volleyball system.

###Properties
Name | Type | Getter | Setter
---|---|---|---|---
name | string | getName | setName
description | string | getDescription | setDescription
types | array | getTypes | setTypes
Organization | [Organization](organization.md) | getOrganization | setOrganization
regions | array | getRegions | setRegions

###Routes
Route Name | Route Path
---|---
volleyball_council_index | /councils
volleyball_council_show | /councils/{slug}
volleyball_council_new | /councils/new

###Controller Actions
Action | Parameters
---|---
Index |
Show | $slug
New | **Request** $request

###Form Types
- CouncilFormType