# ONLINE_GAMES

This aplication resolve the best way to transform a word in other, making 1 letter changes every step.
 Also, every change transform the before word in other.

 Dictionary is in dictionary directory.

You can use this web service:

[POST]{your_server}/participate

In the body you has to add the json contest data in json format:
{
	"contestId": 121,
	"startWord": "dog",
	"endWord": "put"
}

if a solution is found it will be notify to​Wubba Lubba Dub Dub! via post.