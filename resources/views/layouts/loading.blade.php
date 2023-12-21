<div id="circle-loading">
    <div class="loader">
        <div class="loader">
            <div class="loader">
                <div class="loader">

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #circle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 150px;
        height: 150px;
    }

    .loader {
        width: calc(100% - 0px);
        height: calc(100% - 0px);
        border: 8px solid #16253466;
        border-top: 8px solid #09f9;
        border-radius: 50%;
        animation: rotate 5s linear infinite;
    }

    @keyframes rotate {
        100% {
            transform: rotate(360deg);
        }
    }
</style>
<script>
    $(document).ready(function() {
        $("#circle-loading").hide();
    });
</script>