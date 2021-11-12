/**
 * @api {get} /api/positions Get All Positions
 * @apiVersion 1.0.0
 * @apiName Get All Positions
 * @apiGroup Positions
 *
 * @apiDescription Retrieve data employee
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
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/positions"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *    "error": false,
 *    "message": "success",
 *    "data": {
 *        "positions": [
 *            {
 *                "id": "5",
 *                "parent_id": "1",
 *                "position": "Wakil Rektor 2",
 *                "org_unit": "5",
 *                "level": "2"
 *            },
 *            {
 *                "id": "6",
 *                "parent_id": "1",
 *                "position": "Wakil Rektor 3",
 *                "org_unit": "6",
 *                "level": "2"
 *            }
 *        ]
 *    },
 *    "url": "https://hurryup.universitaspertamina.ac.id/api/positions"
 * }
 *
 */