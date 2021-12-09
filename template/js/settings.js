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

    async function getUserInfo() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/settings/getUserInfo.php?userId=' + userId);

        const data = await response.json();

        if(data.length > 0){
            if(data[0]["lastname"] != "" && data[0]["lastname"] != null){
                $("#name").html(data[0]["firstname"]+" "+data[0]["lastname"]);
            } else{
                $("#name").html(data[0]["firstname"]);
            }

            $("#infoEmail").html(data[0]["email"]);
            let momtAgo = moment(data[0]["joined"]).fromNow();
            let momtDate = moment(data[0]["joined"]).format("MMM Do, YY");
            $("#joinedOn").html(momtDate +" ("+ momtAgo +")");
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

    getScore();
    getUserInfo();

    function ValidateEmail(mail)
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
        {
            return (true)
        }

        return (false)
    }

    $(document).on("click","#changeEmailBtn",function(e){
        e.preventDefault();
        let userId = document.getElementById("userId").value;
        let oldEmail = $("#email").val();
        let newEmail = $("#newEmail").val();

        if(oldEmail != "" && newEmail != "" && ValidateEmail(oldEmail) && ValidateEmail(newEmail)){
            $.ajax({
                url: './controller/settings/changeEmail.php',
                data: {userId:userId,oldEmail: oldEmail,newEmail:newEmail},
                type: 'post',
                success: function(output) {
                    if(output.Status == "Success"){
                        toast.fire({
                            icon: 'success',
                            title: 'Email updated!'
                        }).then((result) => {

                        })
                        let oldEmail = $("#email").val("");
                        let newEmail = $("#newEmail").val("");
                        getUserInfo();
                    } else {
                        toast.fire({
                            icon: 'error',
                            title: 'Please valid email address!'
                        }).then((result) => {

                        })
                    }

                },error: function (){
                    toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong!'
                    }).then((result) => {

                    })
                }
            });
        } else {
            toast.fire({
                icon: 'error',
                title: 'Please valid email address!'
            }).then((result) => {

            })
        }
    });


    $(document).on("click","#changePassBtn",function(e){
        e.preventDefault();
        let userId = document.getElementById("userId").value;
        let oldPass = $("#oldPass").val();
        let newPass = $("#newPass").val();

        if(oldPass != "" && newPass != ""){
            $.ajax({
                url: './controller/settings/resetPassword.php',
                data: {userId:userId,oldPass: oldPass,newPass:newPass},
                type: 'post',
                success: function(output) {
                    if(output.Status == "Success"){
                        toast.fire({
                            icon: 'success',
                            title: 'Password changed!'
                        }).then((result) => {

                        })
                        $("#oldPass").val("");
                        $("#newPass").val("");

                    } else {
                        toast.fire({
                            icon: 'error',
                            title: output.Message
                        }).then((result) => {

                        })
                    }

                },error: function (){
                    toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong!'
                    }).then((result) => {

                    })
                }
            });
        } else {
            toast.fire({
                icon: 'error',
                title:"Current password and New password can't be empty"
            }).then((result) => {

            })
        }
    });

    $(document).on("click","#changeProfPicBtn",function(e){
        e.preventDefault();
        var fd = new FormData();
        var files = $('#file')[0].files;

        let userId = document.getElementById("userId").value;

        if(files.length > 0 ){
            fd.append('file',files[0]);
            fd.append("userId",userId);
            $.ajax({
                url: './controller/settings/changeProfilePic.php',
                data: fd,
                contentType: false,
                processData: false,
                type: 'post',
                success: function(output) {
                    if(output.Status == "Success"){
                        toast.fire({
                            icon: 'success',
                            title: 'Profile picture updated!'
                        }).then((result) => {

                        })

                        getUserInfo();

                    } else {
                        toast.fire({
                            icon: 'error',
                            title: 'Unable to update profile picture'
                        }).then((result) => {

                        })
                    }

                },error: function (){
                    toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong!'
                    }).then((result) => {

                    })
                }
            });
        } else {
            toast.fire({
                icon: 'error',
                title:"Upload picture"
            }).then((result) => {

            })
        }
    });
});