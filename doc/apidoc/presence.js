 /**
 * @api {get} /api/presences Get Employee Presences
 * @apiVersion 1.0.0
 * @apiName Get Employee Presences
 * @apiGroup Presences
 *
 * @apiDescription Retrieve data employee presences
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
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/presences"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "success",
 *    "data": {
 *        "countPresences": 2,
 *        "courses": [
 *            {
 *                "id": "5",
 *                "employee_id": "17",
 *                "date": "2021-05-31",
 *                "checkin": "2021-05-31 14:13:52",
 *                "checkout": "2021-05-31 14:14:13",
 *                "duration": "00:00:21",
 *                "status": "2",
 *                "type": "2",
 *                "notes": null,
 *                "updated_by": null
 *            },
 *            {
 *                "id": "19",
 *                "employee_id": "17",
 *                "date": "2021-08-18",
 *                "checkin": "2021-08-18 14:43:39",
 *                "checkout": "2021-08-18 22:52:48",
 *                "duration": "08:09:09",
 *                "status": "2",
 *                "type": "2",
 *                "notes": null,
 *                "updated_by": null
 *            }
 *        ]
 *    },
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/presences"
 * }
 *
 */

 /**
 * @api {post} /api/presences Checkin Employee Presences
 * @apiVersion 1.0.0
 * @apiName Checkin Employee Presences
 * @apiGroup Presences
 *
 * @apiDescription Checkin employee presences
 *
 * @apiHeader {String} Authorization {token}
 * @apiHeader {String} Content-Type application/json
 *
 * @apiParam {String} city City
 * @apiParam {String} temperature Temperature
 * @apiParam {String} condition Condition
 * @apiParam {String} latitude Latitude
 * @apiParam {String} longitude Longitude
 * @apiParam {Array} notes List note
 *
 * @apiSuccess {String} error Error
 * @apiSuccess {String} message Message
 * @apiSuccess {String} url Url
 *
 * @apiErrorExample {json} Error Response:
 * HTTP/1.1 500 Internal Server Error
 * {
 *     "error": true,
 *     "message": "Token invalid",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/presences"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "Data has been created",
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/presences"
 * }
 *
 */
