$(function(){

    let scoreElem = document.getElementById("score");

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const urlSearchQuery = urlParams.get('searchQuery')

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

    getScore();

    async function getSearchedFriends() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/friends/searchNewFriends.php?searchQuery=' + urlSearchQuery);

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

        $("#newFriendsContent").html("");

        $("#searchResults").html(data.length);
        if(data.length > 0){
            for(let i=0;i<data.length;i++){
                let str = '<div class="col-sm-6 text-center" id="singleFriend"><div class="card">';
                str += '<img src="./template/images/'+data[i].photo+'" width="100" height="100" alt="Profile Image" class="friendImageCard" />';
                str += '<div class="card-body"><h5 class="card-title">'+data[i].firstname+'</h5> <a href="#" class="btn btn-success sendFriendRequest" data-frnusid="'+data[i].id+'"><i class="bi bi-person-plus"></i> Send Request</a>';
                str += '</div></div></div>';

                $("#newFriendsContent").append(str);
            }
        } else {
            $("#newFriendsContent").html("<h1>No one found!</h1>");
        }


        //console.log(data);
    }

    getSearchedFriends();


    async function sendFriendRequest($friendUserId) {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/friends/sendFriendRequest.php?userId=' + userId+'&fuserId='+$friendUserId);

        const data = await response.json();

        if(data.Status == "Success"){
            toast.fire({
                icon: 'success',
                title: 'Awesome!!! Request sent!!'
            }).then((result) => {

            })

        } else {
            toast.fire({
                icon: 'error',
                title: "Request already sent!"
            })

        }
        //console.log(data);
    }

    $(document).on("click",".sendFriendRequest",function(e){
        let friendUserId = parseInt($(this).data("frnusid"));
        let status = sendFriendRequest(friendUserId);

        $(this).parent().parent().remove();
    });

});