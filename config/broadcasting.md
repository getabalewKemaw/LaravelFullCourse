| Step | Action          | Laravel Feature           | Purpose / Real-world               |
| ---- | --------------- | ------------------------- | ---------------------------------- |
| 1    | Models & DB     | Eloquent                  | Store users, rooms, messages       |
| 2    | Event           | `ShouldBroadcast`         | Trigger real-time messages         |
| 3    | Channels        | Private / Presence        | Secure rooms & track online users  |
| 4    | Broadcast       | `broadcast()->toOthers()` | Send messages except sender        |
| 5    | Echo setup      | laravel-echo + pusher-js  | Frontend listens to backend events |
| 6    | Frontend listen | `Echo.join()`             | Display messages & active users    |
| 7    | Client events   | `whisper()`               | Typing indicators & live UX        |
| 8    | Notifications   | Broadcast notifications   | Alerts for inactive users          |


