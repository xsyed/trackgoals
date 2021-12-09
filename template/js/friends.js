$(function(){
    let scoreElem = document.getElementById("score");

    const toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    })

    async function getUserInfo() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/settings/getUserInfo.php?userId=' + userId);

        const data = await response.json();

        if(data.length > 0){

            if(data[0].photo == "default.png"){
                $("#profilePic").attr("src","./template/images/"+data[0].photo);
            } else {
                $("#profilePic").attr("src","./template/profileimages/"+data[0].photo);
            }

        } else {
            toast.fire({
                icon: 'error',
                title: 'Unable to receive user info!'
            }).then((result) => {

            })
        }

    }
    getUserInfo();
    async function getScore() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/habits/getScore.php?userId=' + userId);

        const data = await response.json();
        scoreElem.innerHTML = data["Score"];

    }

    async function getAllFriends() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/friends/getAllFriends.php?userId=' + userId);

        const data = await response.json();

        $("#friendsContent").html("");

        $("#friendsCount").html(data.length);

        if(data.length > 0){
            for(let i=0;i<data.length;i++){
                let str = '<div class="col-sm-6 text-center" id="singleFriend"><div class="card">';
                str += '<img src="./template/profileimages/'+data[i].photo+'" style="border-radius: 50%;" width="100" height="100" alt="Profile Image" class="friendImageCard" />';
                str += '<div class="card-body"><h5 class="card-title">'+data[i].firstname+'</h5> <a href="./user/'+data[i].id+'" class="btn btn-primary frndActionBtns"><i class="bi bi-person-badge"></i> Profile</a>';
                str += '<a href="#" class="btn btn-danger frndActionBtns" data-frnusid="'+data[i].id+'"><i class="bi bi-person-dash"></i> Unfriend</a></div></div></div>';

                $("#friendsContent").append(str);
            }
        } else {
            $("#friendsContent").html("<h3 class='text-center my-lg-5'>You have no friends!</h3>");
        }

    }

    getAllFriends();
    getScore();
    getAllFriendRequests();

    $("#friends-tab").click(function(){
        getAllFriends();
    });

    async function unfriend($friendUserId) {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/friends/unfriendApi.php?userId=' + userId+'&fuserId='+$friendUserId);

        const data = await response.json();

        if(data.Status == "Success"){
            toast.fire({
                icon: 'success',
                title: 'You are no longer friend!'
            }).then((result) => {
                getAllFriends();
            })
        }

        //console.log(data);
    }

    $(document).on("click",".frndActionBtns",function(e){
        let friendUserId = parseInt($(this).data("frnusid"));
        unfriend(friendUserId);
    });


    async function getAllFriendRequests() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/friends/getAllFriendRequests.php?userId=' + userId);

        const data = await response.json();


        $("#friendsRequests").html("");

        $("#requestCount").html(data.length);

        if(data.length>0){
            for(let i=0;i<data.length;i++){
                let str = '<div class="col-sm-6 text-center" id="singleFriend"><div class="card">';
                str += '<img src="./template/profileimages/'+data[i].photo+'" style="border-radius: 50%;" width="100" height="100" alt="Profile Image" class="friendImageCard" />';
                str += '<div class="card-body"><h5 class="card-title">'+data[i].firstname+'</h5> <a href="#" class="btn btn-primary acceptFriendRequest frndaction" data-frnusid="'+data[i].sender+'"><i class="bi bi-person-badge"></i> Accept</a>';
                str += '<a href="#" class="btn btn-danger cancelFriendRequest frndaction" data-frnusid="'+data[i].sender+'"><i class="bi bi-person-dash"></i> Ignore</a></div></div></div>';

                $("#friendsRequests").append(str);
            }
        } else {
            $("#friendsRequests").html("<h3 class='text-center my-lg-5'>You have no friend requests!</h3>");
        }


        console.log(data);
    }

    async function cancelFriendRequest($friendUserId) {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/friends/cancelFriendRequest.php?userId=' + userId+'&fuserId='+$friendUserId);

        const data = await response.json();

        if(data.Status == "Success"){
            toast.fire({
                icon: 'success',
                title: 'You have ignored!'
            }).then((result) => {

            })
            getAllFriendRequests();
        }

        //console.log(data);
    }

    $(document).on("click",".cancelFriendRequest",function(e){
        let friendUserId = parseInt($(this).data("frnusid"));
        cancelFriendRequest(friendUserId);
    });

    async function acceptFriendRequest($friendUserId) {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/friends/acceptFriendReq.php?userId=' + userId+'&fuserId='+$friendUserId);

        const data = await response.json();

        if(data.Status == "Success"){
            toast.fire({
                icon: 'success',
                title: 'Hurray!!! You have a new friend!!'
            }).then((result) => {

            })
            getAllFriendRequests();
        }

        //console.log(data);
    }

    $(document).on("click",".acceptFriendRequest",function(e){
        let friendUserId = parseInt($(this).data("frnusid"));
        acceptFriendRequest(friendUserId);
    });

    $("#requests-tab").click(function(){
        getAllFriendRequests();
    });
});