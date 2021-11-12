define({ "api": [
  {
    "type": "post",
    "url": "/api/activities",
    "title": "Create Activity",
    "version": "1.0.0",
    "name": "Create_Activity",
    "group": "Activity",
    "description": "<p>Add data activity employee</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "date_on",
            "description": "<p>Date activity</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "tupoksi",
            "description": "<p>Tupoksi ID</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "duration",
            "description": "<p>Duration activity</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "activity",
            "description": "<p>Activity</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"Data has been created\",\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/activities\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Something went wrong\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/activities\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./activity.js",
    "groupTitle": "Activity"
  },
  {
    "type": "get",
    "url": "/api/activities",
    "title": "Get All Activity Employee",
    "version": "1.0.0",
    "name": "Get_All_Activity_Employee",
    "group": "Activity",
    "description": "<p>Retrieve data tupoksi employee</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Data acativity</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"success\",\n   \"data\": {\n       \"countTimesheets\": 2,\n       \"positions\": [\n           {\n               \"id\": \"5\",\n               \"date_on\": \"2021-08-12\",\n               \"activity\": \"Menulis kode program\",\n               \"duration\": \"300\",\n               \"feedback\": null,\n               \"weight\": \"50\",\n               \"approver_name\": \"Meredita Susanty\",\n               \"status\": \"Approved\"\n           },\n           {\n               \"id\": \"6\",\n               \"date_on\": \"2021-08-13\",\n               \"activity\": \"Menulis kode program\",\n               \"duration\": \"300\",\n               \"feedback\": \"Mantap betul\",\n               \"weight\": \"50\",\n               \"approver_name\": \"Meredita Susanty\",\n               \"status\": \"Approved\"\n           },\n       ]\n   },\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/activities\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Something went wrong\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/activities\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./activity.js",
    "groupTitle": "Activity"
  },
  {
    "type": "put",
    "url": "/api/activities/{id}",
    "title": "Update Feedback Activity",
    "version": "1.0.0",
    "name": "Update_Feedback_Activity",
    "group": "Activity",
    "description": "<p>Update feedback to activity employee</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "feedback",
            "description": "<p>Feedback activity</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"Data has been updated\",\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/activities/{id}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Something went wrong\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/activities/{id}\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./activity.js",
    "groupTitle": "Activity"
  },
  {
    "type": "post",
    "url": "/api/auth",
    "title": "Login",
    "version": "1.0.0",
    "name": "Login",
    "group": "Authenticate",
    "description": "<p>Login</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>Username</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Password</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"error\": false,\n    \"message\": \"success\",\n    \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOswvXC9sb2NhbGhvc3RcL3NpdXBfbW9iaWxlXC92MVwvbG9naW4iLCJpYXQiOjE2MjQyNDg0NjgsImV4cCI6MTYyNDI1MjA2OCwibmJmIjoxNjI0MjQ4NDY4LCJqdGkiOiJncTVmdDNiN0tQMHk3WU9OIiwic3ViIjo4MjE2LCJwcnYiOiJlZjhiZDI1NDE5OWE0ZGY4MTFiZTZjOGRkODNlNTE1YjFiZWM2M2RjIn0.S_9SU-cQtAJMc0Zl2MP7ScL94up5cRyOi1PT719y1UA\"\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/auth\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"error\": true,\n    \"message\": \"Unauthorized access\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/auth\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./auth.js",
    "groupTitle": "Authenticate"
  },
  {
    "type": "get",
    "url": "/api/dropdown/cities",
    "title": "Get All City",
    "version": "1.0.0",
    "name": "Get_All_Positions",
    "group": "Dropdown",
    "description": "<p>Retrieve data city</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Data presences</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"success\",\n   \"data\": {\n       \"countCities\": 499,\n       \"positions\": [\n           {\n               \"id\": \"5\",\n               \"city\": \"Kabupaten Aceh Jaya\",\n               \"latitude\": \"4.7873684\",\n               \"longitude\": \"95.6457951\"\n           },\n           {\n               \"id\": \"6\",\n               \"city\": \"Kabupaten Aceh Selatan\",\n               \"latitude\": \"3.3115056\",\n               \"longitude\": \"97.3516558\"\n           }\n       ]\n   },\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/dropdown/cities\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Something went wrong\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/dropdown/cities\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./dropdown.js",
    "groupTitle": "Dropdown"
  },
  {
    "type": "get",
    "url": "/api/dropdown/tupoksi",
    "title": "Get All Tupoksi Employee",
    "version": "1.0.0",
    "name": "Get_All_Tupoksi_Employee",
    "group": "Dropdown",
    "description": "<p>Retrieve data tupoksi employee</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Data presences</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"success\",\n   \"data\": {\n       \"countCities\": 2,\n       \"positions\": [\n           {\n               \"id\": \"5\",\n               \"position_id\": \"129\",\n               \"tupoksi\": \"Menulis kode program\",\n               \"weight\": \"50\"\n           },\n           {\n               \"id\": \"6\",\n               \"position_id\": \"129\",\n               \"tupoksi\": \"Analisa kebutuhan aplikasi dan sistem\",\n               \"weight\": \"50\"\n           }\n       ]\n   },\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/dropdown/tupoksi\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Something went wrong\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/dropdown/tupoksi\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./dropdown.js",
    "groupTitle": "Dropdown"
  },
  {
    "type": "get",
    "url": "/api/presences",
    "title": "Get Employee",
    "version": "1.0.0",
    "name": "Get_Employee",
    "group": "Employees",
    "description": "<p>Retrieve data employee</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Data presences</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"success\",\n   \"data\": {\n       \"employee\": {\n\t\t      \"employee_id\": \"454\",\n           \"nip\": \"216105\",\n           \"name\": \"Burhan Mafazi\",\n           \"email\": \"burhan.mafazi@universitaspertamina.ac.id\"\n\t\t  },\n       \"positions\": [\n           {\n               \"id\": \"5\",\n               \"position\": \"Programmer\"\n           },\n           {\n               \"id\": \"19\",\n               \"position\": \"Database Administrator\"\n           }\n       ]\n   },\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/employees\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Token invalid\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/employees\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./employee.js",
    "groupTitle": "Employees"
  },
  {
    "type": "get",
    "url": "/api/positions",
    "title": "Get All Positions",
    "version": "1.0.0",
    "name": "Get_All_Positions",
    "group": "Positions",
    "description": "<p>Retrieve data employee</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Data presences</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"success\",\n   \"data\": {\n       \"positions\": [\n           {\n               \"id\": \"5\",\n               \"parent_id\": \"1\",\n               \"position\": \"Wakil Rektor 2\",\n               \"org_unit\": \"5\",\n               \"level\": \"2\"\n           },\n           {\n               \"id\": \"6\",\n               \"parent_id\": \"1\",\n               \"position\": \"Wakil Rektor 3\",\n               \"org_unit\": \"6\",\n               \"level\": \"2\"\n           }\n       ]\n   },\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/positions\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Token invalid\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/positions\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./position.js",
    "groupTitle": "Positions"
  },
  {
    "type": "post",
    "url": "/api/presences",
    "title": "Checkin Employee Presences",
    "version": "1.0.0",
    "name": "Checkin_Employee_Presences",
    "group": "Presences",
    "description": "<p>Checkin employee presences</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>City</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temperature",
            "description": "<p>Temperature</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "condition",
            "description": "<p>Condition</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<p>Latitude</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Longitude</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "notes",
            "description": "<p>List note</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"Data has been created\",\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/presences\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Token invalid\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/presences\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./presence.js",
    "groupTitle": "Presences"
  },
  {
    "type": "get",
    "url": "/api/presences",
    "title": "Get Employee Presences",
    "version": "1.0.0",
    "name": "Get_Employee_Presences",
    "group": "Presences",
    "description": "<p>Retrieve data employee presences</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Data presences</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"success\",\n   \"data\": {\n       \"countPresences\": 2,\n       \"courses\": [\n           {\n               \"id\": \"5\",\n               \"employee_id\": \"17\",\n               \"date\": \"2021-05-31\",\n               \"checkin\": \"2021-05-31 14:13:52\",\n               \"checkout\": \"2021-05-31 14:14:13\",\n               \"duration\": \"00:00:21\",\n               \"status\": \"2\",\n               \"type\": \"2\",\n               \"notes\": null,\n               \"updated_by\": null\n           },\n           {\n               \"id\": \"19\",\n               \"employee_id\": \"17\",\n               \"date\": \"2021-08-18\",\n               \"checkin\": \"2021-08-18 14:43:39\",\n               \"checkout\": \"2021-08-18 22:52:48\",\n               \"duration\": \"08:09:09\",\n               \"status\": \"2\",\n               \"type\": \"2\",\n               \"notes\": null,\n               \"updated_by\": null\n           }\n       ]\n   },\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/presences\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Token invalid\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/presences\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./presence.js",
    "groupTitle": "Presences"
  },
  {
    "type": "get",
    "url": "/api/teams/activity",
    "title": "Get All Activity Subordinates",
    "version": "1.0.0",
    "name": "Get_All_Activity_Subordinates",
    "group": "Teams",
    "description": "<p>Retrieve data activity subordinates</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Data activtiy team</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"success\",\n   \"data\": {\n       \"countTimesheets\": 2,\n       \"positions\": [\n           {\n               \"id\": \"5\",\n               \"name\": \"Burhan Mafazi\",\n               \"nip\": \"216105\",\n               \"date_on\": \"2021-08-12\",\n               \"activity\": \"Menulis kode program\",\n               \"duration\": \"300\",\n               \"weight\": \"50\",\n               \"status\": \"Approved\"\n           },\n           {\n               \"id\": \"6\",\n               \"name\": \"Burhan Mafazi\",\n               \"nip\": \"216105\",\n               \"date_on\": \"2021-08-13\",\n               \"activity\": \"Menulis kode program\",\n               \"duration\": \"300\",\n               \"weight\": \"50\",\n               \"status\": \"Approved\"\n           }\n       ]\n   },\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/teams/activity\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Something went wrong\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/teams/activity\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./team.js",
    "groupTitle": "Teams"
  },
  {
    "type": "put",
    "url": "/api/teams/approval/{id}",
    "title": "Update approval status teams",
    "version": "1.0.0",
    "name": "Update_approval_status_teams",
    "group": "Teams",
    "description": "<p>Update approval status teams</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>{token}</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "approval",
            "description": "<p>Approval (e.g: approve/reject)</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error",
            "description": "<p>Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>Url</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"error\": false,\n   \"message\": \"Data has been updated\",\n   \"url\": \"https://hurryup.universitaspertamina.ac.id/api/teams/approval/{id}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error Response:",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    \"error\": true,\n    \"message\": \"Something went wrong\",\n    \"url\": \"https://hurryup.universitaspertamina.ac.id/api/teams/approval/{id}\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./team.js",
    "groupTitle": "Teams"
  }
] });
