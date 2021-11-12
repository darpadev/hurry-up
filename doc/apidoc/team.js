
 /**
 * @api {put} /api/teams/approval/{id} Update approval status teams
 * @apiVersion 1.0.0
 * @apiName Update approval status teams
 * @apiGroup Teams
 *
 * @apiDescription Update approval status teams
 *
 * @apiHeader {String} Authorization {token}
 * @apiHeader {String} Content-Type application/json
 *
 * @apiParam {String} approval Approval (e.g: approve/reject)
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
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/teams/approval/{id}"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "Data has been updated",
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/teams/approval/{id}"
 * }
 *
 */


 /**
 * @api {get} /api/teams/activity Get All Activity Subordinates
 * @apiVersion 1.0.0
 * @apiName Get All Activity Subordinates
 * @apiGroup Teams
 *
 * @apiDescription Retrieve data activity subordinates
 *
 * @apiHeader {String} Authorization {token}
 *
 * @apiSuccess {String} error Error
 * @apiSuccess {String} message Message
 * @apiSuccess {Object} data Data activtiy team
 * @apiSuccess {String} url Url
 *
 * @apiErrorExample {json} Error Response:
 * HTTP/1.1 500 Internal Server Error
 * {
 *     "error": true,
 *     "message": "Something went wrong",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/teams/activity"
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
 *                "name": "Burhan Mafazi",
 *                "nip": "216105",
 *                "date_on": "2021-08-12",
 *                "activity": "Menulis kode program",
 *                "duration": "300",
 *                "weight": "50",
 *                "status": "Approved"
 *            },
 *            {
 *                "id": "6",
 *                "name": "Burhan Mafazi",
 *                "nip": "216105",
 *                "date_on": "2021-08-13",
 *                "activity": "Menulis kode program",
 *                "duration": "300",
 *                "weight": "50",
 *                "status": "Approved"
 *            }
 *        ]
 *    },
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/teams/activity"
 * }
 *
 */