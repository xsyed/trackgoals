$(function(){
    let scoreElem = document.getElementById("score");

    const toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    })

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
            /*<div class="col-sm-6 text-center" id="singleFriend">
                                    <div class="card">
                                        <img src="./template/images/default.png" width="100" height="100" alt="..." class="friendImageCard">
                                        <div class="card-body">
                                            <h5 class="card-title">Sam</h5>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                            <a href="#" class="btn btn-primary"><i class="bi bi-person-badge"></i> Profile</a>
                                            <a href="#" class="btn btn-danger"><i class="bi bi-person-dash"></i> Unfriend</a>
                                        </div>
                                    </div>
                                </div>*/

        $("#friendsContent").html("");

        $("#friendsCount").html(data.length);

        for(let i=0;i<data.length;i++){
            let str = '<div class="col-sm-6 text-center" id="singleFriend"><div class="card">';
            str += '<img src="./template/images/'+data[i].photo+'" width="100" height="100" alt="Profile Image" class="friendImageCard" />';
            str += '<div class="card-body"><h5 class="card-title">'+data[i].firstname+'</h5> <a href="./user/'+data[i].id+'" class="btn btn-primary frndActionBtns"><i class="bi bi-person-badge"></i> Profile</a>';
            str += '<a href="#" class="btn btn-danger frndActionBtns" data-frnusid="'+data[i].id+'"><i class="bi bi-person-dash"></i> Unfriend</a></div></div></div>';

            $("#friendsContent").append(str);
        }

        console.log(data);
    }

    getAllFriends();
    getScore();


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
        /*<div class="col-sm-6 text-center" id="singleFriend">
                                <div class="card">
                                    <img src="./template/images/default.png" width="100" height="100" alt="..." class="friendImageCard">
                                    <div class="card-body">
                                        <h5 class="card-title">Sam</h5>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <a href="#" class="btn btn-primary"><i class="bi bi-person-badge"></i> Profile</a>
                                        <a href="#" class="btn btn-danger"><i class="bi bi-person-dash"></i> Unfriend</a>
                                    </div>
                                </div>
                            </div>*/

        $("#friendsRequests").html("");

        $("#requestCount").html(data.length);

        for(let i=0;i<data.length;i++){
            let str = '<div class="col-sm-6 text-center" id="singleFriend"><div class="card">';
            str += '<img src="./template/images/'+data[i].photo+'" width="100" height="100" alt="Profile Image" class="friendImageCard" />';
            str += '<div class="card-body"><h5 class="card-title">'+data[i].firstname+'</h5> <a href="#" class="btn btn-primary acceptFriendRequest" data-frnusid="'+data[i].sender+'"><i class="bi bi-person-badge"></i> Accept</a>';
            str += '<a href="#" class="btn btn-danger cancelFriendRequest" data-frnusid="'+data[i].sender+'"><i class="bi bi-person-dash"></i> Ignore</a></div></div></div>';

            $("#friendsRequests").append(str);
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
                getAllFriendRequests();
            })
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
                getAllFriendRequests();
            })
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