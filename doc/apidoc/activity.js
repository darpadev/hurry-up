
 /**
 * @api {get} /api/activities Get All Activity Employee
 * @apiVersion 1.0.0
 * @apiName Get All Activity Employee
 * @apiGroup Activity
 *
 * @apiDescription Retrieve data tupoksi employee
 *
 * @apiHeader {String} Authorization {token}
 *
 * @apiSuccess {String} error Error
 * @apiSuccess {String} message Message
 * @apiSuccess {Object} data Data acativity
 * @apiSuccess {String} url Url
 *
 * @apiErrorExample {json} Error Response:
 * HTTP/1.1 500 Internal Server Error
 * {
 *     "error": true,
 *     "message": "Something went wrong",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/activities"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "success",
 *    "data": {
 *        "countTimesheets": 2,
 *        "positions": [
 *            {
 *                "id": "5",
 *                "date_on": "2021-08-12",
 *                "activity": "Menulis kode program",
 *                "duration": "300",
 *                "feedback": null,
 *                "weight": "50",
 *                "approver_name": "Meredita Susanty",
 *                "status": "Approved"
 *            },
 *            {
 *                "id": "6",
 *                "date_on": "2021-08-13",
 *                "activity": "Menulis kode program",
 *                "duration": "300",
 *                "feedback": "Mantap betul",
 *                "weight": "50",
 *                "approver_name": "Meredita Susanty",
 *                "status": "Approved"
 *            },
 *        ]
 *    },
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/activities"
 * }
 *
 */


 /**
 * @api {post} /api/activities Create Activity
 * @apiVersion 1.0.0
 * @apiName Create Activity
 * @apiGroup Activity
 *
 * @apiDescription Add data activity employee
 *
 * @apiHeader {String} Authorization {token}
 *
 * @apiParam {Array} date_on Date activity 
 * @apiParam {Array} tupoksi Tupoksi ID 
 * @apiParam {Array} duration Duration activity 
 * @apiParam {Array} activity Activity 
 *
 * @apiSuccess {String} error Error
 * @apiSuccess {String} message Message
 * @apiSuccess {String} url Url
 *
 * @apiErrorExample {json} Error Response:
 * HTTP/1.1 500 Internal Server Error
 * {
 *     "error": true,
 *     "message": "Something went wrong",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/activities"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "Data has been created",
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/activities"
 * }
 *
 */

 /**
 * @api {put} /api/activities/{id} Update Feedback Activity
 * @apiVersion 1.0.0
 * @apiName Update Feedback Activity
 * @apiGroup Activity
 *
 * @apiDescription Update feedback to activity employee
 *
 * @apiHeader {String} Authorization {token}
 * @apiHeader {String} Content-Type application/json
 *
 * @apiParam {String} feedback Feedback activity 
 *
 * @apiSuccess {String} error Error
 * @apiSuccess {String} message Message
 * @apiSuccess {String} url Url
 *
 * @apiErrorExample {json} Error Response:
 * HTTP/1.1 500 Internal Server Error
 * {
 *     "error": true,
 *     "message": "Something went wrong",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/activities/{id}"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "Data has been updated",
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/activities/{id}"
 * }
 *
 */