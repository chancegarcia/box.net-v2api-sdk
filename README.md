box.net-v2api-sdk
=================

Requires at least 5.6.10

php sdk for use with box.net v2 api (http://developers.box.com/)

Copyright (C) 2013-2016  Chance Garcia

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.

tasks:
- [ ] v0.4.0
  - [x] refactor `Connection::getCurlData` to return an HTTP Response object (use symfony/http-foundation)
    - [x] method to turn curl header string into header array to set in Response object
    - [x] method to determine status code given header string
    - [x] Existing calls in the `Client` class must still only analyse the body response
  - [x] `Service` class final methods analyze the Response object to determine error/response handling such as refresh token attempt
    - [x] Deprecate `Service::getFinalConnectionResult` and add warning of removal in v0.5.0
- [ ] v0.4.1
  - [ ] refactor `Service::getFromBox` to accept type `mapped`
  - [ ] refactor `Service::sendUpdateToBox` to accept type `mapped`
  - [ ] add handling for 409 `item_name_in_use` error
- [ ] v0.5.0
  - [ ] Remove `Service::getFinalConnectionResult`
  - [ ] Add deprecation notice that the Client class will be removed. exact version removal undetermined
  - [ ] Add deprecation notice that the `Collection` class will be removed in v0.6.0 in favor of using `doctrine/collections`
  - [ ] methods to set `CURLOPT_SSL_VERIFYPEER` in `Connection` class
    - [ ] add deprecation notice that default value will be true in later release to allow time for migration from current behavior (false)
  - [ ] refactor
    - [ ] support PSR-7 (HTTP Messages)
      - [PSR-7](http://www.php-fig.org/psr/psr-7/)
      - [GitHub](https://github.com/php-fig/http-message)
      - [PSR-7 Example](https://mwop.net/blog/2015-01-26-psr-7-by-example.html)
      - [RFC 7231 Section 6](http://tools.ietf.org/html/rfc7231#section-6)
- [ ] v0.6.0
  - [ ] go to full composer dependency mode
  - [ ] add composer `doctrine/collections` requirement
  - [ ] implement `Retry-After` response header handling in abstract `Service`
  
tasks for version less than 0.4.0
- [ ] Client class
    - Note: token information as well as client id and secret are set from outside source/storage
    - [x] get access token given authorization code
    - [x] refresh token
    - [x] retrieve folder information from box given id
    - [x] get array of folder items (json decoded format)
    - [x] create new box folder
    - [ ] update folder information
    - [x] get folder collaborators
    - [x] add collaborator to a folder
    - [x] create shared link for folder
    - [x] copy box folder
    - [x] create authorization header for connection class using token
    - [x] destroy token
        - [ ] add error handling
    - [x] auth query
        - [x] build auth query uri
        - [x] set auth header for connection
            - [ ] allow additional headers to be merged because of header overwrite
    - [x] client id
    - [x] client secret
- [x] Collaboration class
    - [x] interface implemented
    - [x] validate status
- [ ] Collection class
    - figure out how to create dependency to an array collection library; not as separatable but better than maintaining our own/re-inventing the wheel
- [x] Connection class
    - [x] interface implemented
    - [x] ability to set additional curl opts
    - [x] send GET request
    - [x] return GET response
    - [x] send PUT request
    - [x] return PUT response
    - [x] send POST request
    - [x] return POST response
    - [ ] send DELETE request
    - [ ] return DELETE response
- [x] Token class
- [ ] Folder class
    - [x] interface implemented
- [ ] User class
    - [x] interface implemented
- [ ]  File class
    - [x] interface implemented
- [ ]  Comment class
- [ ]  Event class
- [ ]  Shared Items interaction
    - [x] create shared link (can be done via client)
- [ ]  Search
- [ ]  Task Class
- [ ] Unit Tests
    - [ ] Regression for current implementation
    - [ ] TDD for future implementation