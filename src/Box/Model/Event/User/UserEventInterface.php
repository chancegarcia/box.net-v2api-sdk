<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/17/15
 * Time: 5:30 PM
 */

namespace Box\Model\Event\User;


use Box\Model\Event\EventInterface;

interface UserEventInterface extends EventInterface
{
    const URI = "https://api.box.com/2.0/events";

    /**
     * A folder or File was created
     */
    const ITEM_CREATE = "ITEM_CREATE";
    /**
     * A folder or File was uploaded
     */
    const ITEM_UPLOAD = "ITEM_UPLOAD";
    /**
     * A comment was created on a folder, file, or other comment
     */
    const COMMENT_CREATE = "COMMENT_CREATE";
    /**
     * A file or folder was downloaded
     */
    const ITEM_DOWNLOAD = "ITEM_DOWNLOAD";
    /**
     * A file was previewed
     */
    const ITEM_PREVIEW = "ITEM_PREVIEW";
    /**
     * A file or folder was moved
     */
    const ITEM_MOVE = "ITEM_MOVE";
    /**
     * A file or folder was copied
     */
    const ITEM_COPY = "ITEM_COPY";
    /**
     * A task was assigned
     */
    const TASK_ASSIGNMENT_CREATE = "TASK_ASSIGNMENT_CREATE";
    /**
     * A file was locked
     */
    const LOCK_CREATE = "LOCK_CREATE";
    /**
     * A file was unlocked
     */
    const LOCK_DESTROY = "LOCK_DESTROY";
    /**
     * A file or folder was marked as deleted
     */
    const ITEM_TRASH = "ITEM_TRASH";
    /**
     * A file or folder was recovered out of the trash
     */
    const ITEM_UNDELETE_VIA_TRASH = "ITEM_UNDELETE_VIA_TRASH";
    /**
     * A collaborator was added to a folder
     */
    const COLLAB_ADD_COLLABORATOR = "COLLAB_ADD_COLLABORATOR";
    /**
     * A collaborator had their role changed
     */
    const COLLAB_ROLE_CHANGE = "COLLAB_ROLE_CHANGE";
    /**
     * A collaborator was invited on a folder
     */
    const COLLAB_INVITE_COLLABORATOR = "COLLAB_INVITE_COLLABORATOR";
    /**
     * A collaborator was removed from a folder
     */
    const COLLAB_REMOVE_COLLABORATOR = "COLLAB_REMOVE_COLLABORATOR";
    /**
     * A folder was marked for sync
     */
    const ITEM_SYNC = "ITEM_SYNC";
    /**
     * A folder was un-marked for sync
     */
    const ITEM_UNSYNC = "ITEM_UNSYNC";
    /**
     * A file or folder was renamed
     */
    const ITEM_RENAME = "ITEM_RENAME";
    /**
     * A file or folder was enabled for sharing
     */
    const ITEM_SHARED_CREATE = "ITEM_SHARED_CREATE";
    /**
     * A file or folder was disabled for sharing
     */
    const ITEM_SHARED_UNSHARE = "ITEM_SHARED_UNSHARE";
    /**
     * A folder was shared
     */
    const ITEM_SHARED = "ITEM_SHARED";
    /**
     * A Tag was added to a file or folder
     */
    const TAG_ITEM_CREATE = "TAG_ITEM_CREATE";
    /**
     * A user is logging in from a device we haven’t seen before
     */
    const ADD_LOGIN_ACTIVITY_DEVICE = "ADD_LOGIN_ACTIVITY_DEVICE";
    /**
     * We invalidated a user session associated with an app
     */
    const REMOVE_LOGIN_ACTIVITY_DEVICE = "REMOVE_LOGIN_ACTIVITY_DEVICE";
    /**
     * When an admin role changes for a user
     */
    const CHANGE_ADMIN_ROLE = "CHANGE_ADMIN_ROLE";


}