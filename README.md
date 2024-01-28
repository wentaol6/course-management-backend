# course_management
##Apis
### GET /php-server/management?searchKey=user_id&searchValue=1&table=users
Response
[
    {
        "user_id": 1,
        "first_name": "John",
        "surname": "Doe"
    }
]
{
    "error": "Record not found"
}

### POST /php-server/management?table=users
Request
{
    "first_name": "firstName",
    "surname": "surname"
}
Response
{
    "message": "Data inserted successfully"
}

### PUT /php-server/management?searchKey=user_id&searchValue=1&table=users
Request
{
    "first_name": "firstName",
    "surname": "surname"
}
Response
{
    "message": "Data updated successfully"
}
{
    "error": "No matching records found"
}

###DELETE /php-server/management?searchKey=user_id&searchValue=1&table=users
Response
{
    "message": "Record deleted successfully"
}
{
    "message": "No record found with given ID"
}
