<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <!-- Main CSS file -->
        @vite('resources/css/app.css')

        <style>

        </style>

        <title>Laravel</title>
    </head>
    <body class="antialiased bg-gray-100">
        <div class="flex justify-center pt-16">
            <div id="calculator" class="max-sm:w-10/12 sm:w-7/12 md:w-5/12 lg:w-3/12 bg-white border-2 rounded-xl">
                <div class="flex">
                    <div class="w-6/12">
                        <p id="output" class="text-5xl font-bold m-5 text-gray-500">0.00</p>
                    </div>
                    <div class="flex justify-end w-6/12 pr-5 my-auto">
                        <div id="reset-btn" onclick="reset()" class="hidden bg-orange-100 text-orange-500 px-2 py-1 cursor-pointer rounded-full w-fit">
                            <i class="fa fa-repeat"></i>
                        </div>
                    </div>
                </div>
                <div id="blocks" class="rounded-xl grid grid-cols-4 text-center">
                    <div onclick="type(this)" class="number rounded-tl-xl border-t border-b border-r">1</div>
                    <div onclick="type(this)" class="number border-t border-b border-r">2</div>
                    <div onclick="type(this)" class="number border-r rounded-tr-xl border-t border-b">3</div>
                    <div onclick="operate(this)" class="operation border-b rounded-t-xl border-t">+</div>
                    <div onclick="type(this)" class="number border-b border-r">4</div>
                    <div onclick="type(this)" class="number border-b border-r">5</div>
                    <div onclick="type(this)" class="number border-b border-r">6</div>
                    <div onclick="operate(this)" class="operation border-b">–</div>
                    <div onclick="type(this)" class="number border-b rounded-bl-xl border-r">7</div>
                    <div onclick="type(this)" class="number border-b border-r">8</div>
                    <div onclick="type(this)" class="number border-b border-r rounded-br-xl">9</div>
                    <div onclick="operate(this)" class="operation border-b ">x</div>
                    <div class="col-span-1"></div>
                    <div onclick="type(this)" class="col-span-1 number rounded-b border-x border-b">0</div>
                    <div class="col-span-1"></div>
                    <div onclick="operate(this)" class="operation rounded-b-xl border-l border-b">÷</div>
                    <div onclick="calculate()" class="col-span-4 mt-4 py-5 transition rounded-xl bg-gray-500 text-white equal rounded-b-xl cursor-pointer hover:rounded-xl hover:opacity-80">=</div>
                </div>
            </div>

            <div id="logs" class="pt-5 pl-4">
                <p class="text-3xl text-white font-bold">Logs</p>
                <div id="calculations" class="mt-5">
                    <!-- Logs will be appended here -->
                </div>
            </div>
        </div>
    </body>

    <script>
        let output = document.querySelector('#output')
        let logs = document.querySelector('#logs')
        let resetBtn = document.querySelector('#reset-btn')

        let type = el => {
            output.textContent === '0.00'
                ? output.textContent = el.textContent
                : output.textContent += el.textContent
        }

        let operate = el => {
            let outputContent = output.textContent

            if (outputContent.includes('+') || outputContent.includes('–') || outputContent.includes('x') || outputContent.includes('÷')) {
                resetBtn.classList.add('hidden')
                return output.textContent = '0.00'
            } else if (outputContent === '0.00') {
                return;
            }

            output.textContent += ` ${el.textContent} `
            resetBtn.classList.remove('hidden')
        }

        let calculate = () => {
            fetch('{{ route('calculate') }}', {
                    method: 'POST',
                    body: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        input: output.textContent
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(res => res.json())
                    .then(res => {
                        output.textContent = res.output

                        logs.style.width = '15%'

                        logs.querySelector('#calculations').innerHTML += `<p class="text-white">${res.log.first_number} ${res.log.operation} ${res.log.second_number} = ${res.output}</p>`
                    }).catch(err => {
                        console.log(err)
                    })
        }

        let reset = () => {
            output.textContent = '0.00'

            resetBtn.classList.add('hidden')
        }
    </script>

</html>
