/**
 * @api {get} /api/dropdown/cities Get All City
 * @apiVersion 1.0.0
 * @apiName Get All Positions
 * @apiGroup Dropdown
 *
 * @apiDescription Retrieve data city
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
 *     "message": "Something went wrong",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/dropdown/cities"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "success",
 *    "data": {
 *        "countCities": 499,
 *        "positions": [
 *            {
 *                "id": "5",
 *                "city": "Kabupaten Aceh Jaya",
 *                "latitude": "4.7873684",
 *                "longitude": "95.6457951"
 *            },
 *            {
 *                "id": "6",
 *                "city": "Kabupaten Aceh Selatan",
 *                "latitude": "3.3115056",
 *                "longitude": "97.3516558"
 *            }
 *        ]
 *    },
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/dropdown/cities"
 * }
 *
 */

 /**
 * @api {get} /api/dropdown/tupoksi Get All Tupoksi Employee
 * @apiVersion 1.0.0
 * @apiName Get All Tupoksi Employee
 * @apiGroup Dropdown
 *
 * @apiDescription Retrieve data tupoksi employee
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
 *     "message": "Something went wrong",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/dropdown/tupoksi"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "success",
 *    "data": {
 *        "countCities": 2,
 *        "positions": [
 *            {
 *                "id": "5",
 *                "position_id": "129",
 *                "tupoksi": "Menulis kode program",
 *                "weight": "50"
 *            },
 *            {
 *                "id": "6",
 *                "position_id": "129",
 *                "tupoksi": "Analisa kebutuhan aplikasi dan sistem",
 *                "weight": "50"
 *            }
 *        ]
 *    },
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/dropdown/tupoksi"
 * }
 *
 */