<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>login</title>
</head>
<body class="flex items-center justify-center h-screen w-full bg-[#cfcece]">
    <div class="bg-white">
        <div class="bg-red-700 text-white weight text-center font-semibold text-2xl">GYMATE</div>
            <form class="p-8 flex gap-7 flex-col">
                <div class="flex flex-col gap-1">
                    <label for="" class="capitalize">username</label>
                    <input type="text" class="rounded-md w-[400px] bg-zinc-200 border-none"> 
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="capitalize">password</label>
                    <input type="text" class="rounded-md border-none bg-zinc-200"> 
                </div>
                <div class="flex flex-row gap-2 justify-end">
                    <a href="">
                        <button type="submit" class="uppercase text-white px-4 py-2 rounded-lg bg-[#656565] ">daftar</button>
                    </a>
                    <button type="submit" class="uppercase text-white px-4 py-2 rounded-lg bg-[#1E1E1E] ">login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>