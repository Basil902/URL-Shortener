<x-layout>
    <div class="w-screen h-screen bg-blue-400 p-15 text-center">
        <h1 class="text-2xl text-white font-bold">Hello {{$user -> username}}!</h1>
        <p class="text-white font-bold">Your bisherigen gekürzten Links:</p>
        {{-- in dem div die bisherigfen links anzeigen --}}
        <div class="w-250 ml-auto mr-auto">
            <ul>
                @foreach($links as $link)
                <a href="http://{{$link}}" class="bg-gray-50 hover:bg-gray-200 m-3 p-4 rounded-lg block text-black no-underline border-0">{{$link}}</a>
                @endforeach
            </ul>
        </div>
    
    
    </div>
</x-layout>