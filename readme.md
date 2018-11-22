Hello!!!

This app is a news website where readers can read news and comment and reply if they are registered/authenticated. In the backend, there are 3 types of users: adminstrator, moderator and journalist.

Administrator can create categories and manage their position, create other users and manage their roles, manage website settings (address, about me, website name...).

Journalist can write articles, save articles and send them for approval. He can't change approved articles.

Moderator can approve, unapprove or delete articles, written by journalists, approve or unapprove comments and replies written by users, put which articles will be in the slider on the frontend.

Administrator, moderator and journalist can write internal mails to eachother.
They can look at all articles but only moderator can approve or delete other users articles.

This app was made using:
<br/>    - Frontend theme: "World" from https://themewagon.com with it's dependencies
<br/>    - Admin layout SB Admin
<br/>    - Laravel framework
<br/>    - Bootstrap
<br/>    - JavaScript
<br/>    - Ajax

Dependencies:
<br/>    - hashids: https://github.com/ivanakimov/hashids.php#readme
<br/>    - slug: cviebrock/eloquent-sluggable:^4.6
<br/>    - toastr: yoeunes/toastr
<br/>    - CKEeditor

You can see it live on https://bozidarnews.000webhostapp.com/. I have left debug=>true to see the errors.

Cheers!!!
