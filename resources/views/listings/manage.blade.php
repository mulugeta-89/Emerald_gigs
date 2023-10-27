<x-layout>
<div class="bg-emerald-300 border border-gray-200 p-10 rounded">
    <header>
        <h1
            class="text-3xl text-center font-bold my-6 uppercase text-white"
        >
            Manage Gigs
        </h1>
    </header>

    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless(count($listings) == 0)
            @foreach($listings as $listing)
            <tr class="border-gray-300">
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a href="/listing/{{$listing->id}}" class="text-white">
                        {{$listing->title}}
                    </a>
                </td>
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a
                        href="/listings/{{$listing->id}}/edit"
                        class="text-white px-6 py-2 rounded-xl"
                        ><i
                            class="fa-solid fa-pen-to-square"
                        ></i>
                        Edit</a
                    >
                </td>
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <form method="POST" action="/listings/{{$listing->id}}">
                        @csrf
                        @method("DELETE")
                        <button class="text-red-600">
                            <i
                                class="fa-solid fa-trash-can"
                            ></i>
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <p class="text-center text-white">No Listings Found</p>
                </td>
            </tr>
            @endunless

        </tbody>
    </table>
</div>
</x-layout>