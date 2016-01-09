#Volleyball
##Summer Camp Scheduling System
###Organization Bundle

Region element for the Organization Bundle of the Volleyball system.

###Properties
Name | Type | Getter | Setter
---|---|---|---|---
name | string | getName | setName
description | string | getDescription | setDescription
types | array | getTypes | setTypes
Organization | [Organization](organization.md) | getOrganization | setOrganization
Council | [Council](council.md) | getCouncil | setCouncil

###Routes
Route Name | Route Path
---|---
volleyball_region_index | /regions
volleyball_region_show | /regions/{slug}
volleyball_region_new | /regions/new

###Controller Actions
Action | Parameters
---|---
Index |
Show | $slug
New | **Request** $request

###Form Types
- RegionFormType