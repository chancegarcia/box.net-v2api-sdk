box.net-v2api-sdk
=================

Requires at least 5.4.0

php sdk for use with box.net v2 api (http://developers.box.com/)

This is my first time building a separate library/module. It is intended to follow the coding standards of ZF2
but initial use will be in another framework.

tasks:
- [ ] Client class
    - Note: token information as well as client id and secret are set from outside source/storage
    - [x] get access token given authorization code
    - [x] refresh token
    - [x] retrieve folder information from box given id
    - [x] get array of folder items (json decoded format)
    - [ ] create new box folder
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
- [x] Connection class
    - [x] interface implemented
    - [x] ability to set additional curl opts
    - [x] send GET request
    - [x] return GET response
    - [x] send PUT request
    - [x] return PUT response
    - [x] send POST request
    - [x] return POST response
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

