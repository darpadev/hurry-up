/**
 * @api {post} /api/auth Login
 * @apiVersion 1.0.0
 * @apiName Login
 * @apiGroup Authenticate
 *
 * @apiDescription Login
 *
 * @apiParam {String} username Username
 * @apiParam {String} password Password
 *
 * @apiHeader  {String} Content-Type application/json
 *
 * @apiSuccess {String} error Error
 * @apiSuccess {String} message Message
 * @apiSuccess {String} token Token
 * @apiSuccess {String} url Url
 *
 * @apiErrorExample {json} Error Response:
 * HTTP/1.1 401 Unauthorized
 * {
 *     "error": true,
 *     "message": "Unauthorized access",
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/auth"
 * }
 *
 * @apiSuccessExample {json} Success Response:
 * HTTP/1.1 200 OK
 * {
 *     "error": false,
 *     "message": "success",
 *     "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOswvXC9sb2NhbGhvc3RcL3NpdXBfbW9iaWxlXC92MVwvbG9naW4iLCJpYXQiOjE2MjQyNDg0NjgsImV4cCI6MTYyNDI1MjA2OCwibmJmIjoxNjI0MjQ4NDY4LCJqdGkiOiJncTVmdDNiN0tQMHk3WU9OIiwic3ViIjo4MjE2LCJwcnYiOiJlZjhiZDI1NDE5OWE0ZGY4MTFiZTZjOGRkODNlNTE1YjFiZWM2M2RjIn0.S_9SU-cQtAJMc0Zl2MP7ScL94up5cRyOi1PT719y1UA"
 *     "url": "https://hurryup.universitaspertamina.ac.id/api/auth"
 * }
 *
 */