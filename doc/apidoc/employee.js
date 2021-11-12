/**
 * @api {get} /api/presences Get Employee
 * @apiVersion 1.0.0
 * @apiName Get Employee
 * @apiGroup Employees
 *
 * @apiDescription Retrieve data employee
 *
 * @apiHeader {String} Authorization {token}
 *
 * @apiSuccess {String} error Error
 * @apiSuccess {String} message Message
 * @apiSuccess {Object} data Data presences
 * @apiSuccess {String} url Url
 *
 * @apiErrorExample {json} Error Response:
 * HTTP/1.1 500 Internal Server Error
 * {
 *     "error": true,
 *     "message": "Token invalid",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/employees"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "success",
 *    "data": {
 *        "employee": {
 *		      "employee_id": "454",
 *            "nip": "216105",
 *            "name": "Burhan Mafazi",
 *            "email": "burhan.mafazi@universitaspertamina.ac.id"
 *		  },
 *        "positions": [
 *            {
 *                "id": "5",
 *                "position": "Programmer"
 *            },
 *            {
 *                "id": "19",
 *                "position": "Database Administrator"
 *            }
 *        ]
 *    },
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/employees"
 * }
 *
 */