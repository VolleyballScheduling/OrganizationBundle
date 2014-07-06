#Volleyball
##Summer Camp Scheduling System
###Organization Bundle

Organization element for the Organization Bundle of the Volleyball system.

###Properties
Name | Type | Getter | Setter
---|---|---|---|---
name | string | getName | setName
description | string | getDescription | setDescription
types | array | getTypes | setTypes
councils | array | getCouncils | setCouncils
regions | array | getRegions | setRegions

###Routes
Route Name | Route Path
---|---
volleyball_organization_index | /organizations
volleyball_organization_show | /organizations/{slug}
volleyball_organization_new | /organizations/new

###Controller Actions
Action | Parameters
---|---
Index |
Show | $slug
New | **Request** $request

###Form Types
- OrganizationFormType