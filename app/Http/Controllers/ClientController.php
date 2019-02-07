<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function showAllClients()
    {
        return response()->json(Client::all());
    }

    public function showSomeClients(Request $request, $clients = null)
    {
        // Test database connection
        try {
            app('db')->getPdo();
        } catch (\Exception $e) {
            return response()->json(null, 503);
        }

        if (empty($clients)) {
            $clients = Client::paginate(50);
        }   
        
        $rawLinks = $clients->links();
        $firstMatch = substr($rawLinks, 0, strpos($rawLinks, '</li>'));
        preg_match_all("/<li (.*)<\/li>/m", $clients->links(), $matches);
        $lastMatch = substr($rawLinks, strrpos($rawLinks, '<li '), -1);

        array_unshift($matches[0], $firstMatch);
        array_push($matches[0], $lastMatch);

        $links = [];
        foreach($matches[0] as $match) {
            $link = [];

            $link['isActive'] = (strpos($match, 'active') !== false);
            $link['isDisabled'] = (strpos($match, 'disabled') !== false);
            $link['showLink'] = (strpos($match, '<a') !== false);
            $link['showSpan'] = (strpos($match, '<span') !== false);

            preg_match('/rel="(.*)" /', $match, $matchRelation);
            @$link['relation'] = $matchRelation[0];
            
            preg_match('/<(a|span) (.*)">(.*)<\/(a|span)/', $match, $matchText);
            @$link['text'] = $matchText[3];

            preg_match('/href="(.*)"/', $match, $matchUrl);
            @$link['url'] = (strpos($matchUrl[1], '"') === false) ? $matchUrl[1] : strstr($matchUrl[1], '"', true);

            $links[] = $link;
        }

        $items = (array) $clients->items();


        return response()->json([
            'items' => $items,
            'links' => $links]);
    }

    public function showOneClient($id)
    {
        return response()->json(Client::find($id));
    }

    public function searchClients(Request $request)
    {
        // Test database connection
        try {
            app('db')->getPdo(); 
        } catch (\Exception $e) {
            return response()->json(null, 503);
        }

        $guild = $request->input('guild', '');
        $first = $request->input('first', '');
        $last = $request->input('last', '');
        $street = $request->input('street', '');
        $city = $request->input('city', '');
        $zip = $request->input('zip', '');

        $clients = Client::whereNotNull('guild');

        if (!empty($guild))
            $clients->where('guild', 'like', '%'.$guild.'%');    
        if (!empty($first))
            $clients->where('first', 'like', '%'.$first.'%');    
        if (!empty($last))
            $clients->where('last', 'like', '%'.$last.'%');    
        if (!empty($street))
            $clients->where('street', 'like', '%'.$street.'%');    
        if (!empty($city))
            $clients->where('city', 'like', '%'.$city.'%');    
        if (!empty($zip))
            $clients->where('zip', 'like', '%'.$zip.'%');  
            
        $clients->paginate(50);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'city' => 'required',
            'guid' => 'required|unique:clients',
            'zip' => 'required|alpha'
        ]);

        $client = Client::create($request->all());

        return response()->json($client, 201);
    }

    public function update($id, Request $request)
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());

        return response()->json($client, 200);
    }

    public function delete($id)
    {
        Client::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function TestAPI() 
    {
    }
}