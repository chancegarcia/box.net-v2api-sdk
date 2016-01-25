box.net-v2api-sdk
=================

Requires at least 5.6.10

php sdk for use with box.net v2 api (http://developers.box.com/)

Copyright (C) 2013-2016  Chance Garcia

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

tasks:
- [ ] v0.5.0
  - [ ] Add deprecation notice that the Client class will be removed. exact version removal undetermined
  - [ ] Add deprecation notice that the `Collection` class will be removed in v0.6.0
- [ ] v0.6.0
  - go to full composer dependency mode
  - add composer `doctrine/collections` requirement
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