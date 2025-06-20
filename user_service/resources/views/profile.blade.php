<x-layout>
    <div class="w-screen h-screen bg-blue-400 p-15 text-center">
        <h1 class="text-2xl text-white font-bold">Hello {{$user -> username}}!</h1>
        <div class="w-250 ml-auto mr-auto">
            <ul>
                @if (!empty($links))
                    <p class="text-white font-bold">Your previously shortened links:</p>
                    @foreach($links as $link)
                    <a href="http://{{$link}}" target="_blank" class="bg-gray-50 hover:bg-gray-200 m-3 p-4 rounded-lg block text-black no-underline border-0">{{$link}}</a>
                    @endforeach
                @else
                    <p class="text-white font-bold">You have no shortened links.</p>
                @endif
            </ul>
        </div>
    </div>
</x-layout>