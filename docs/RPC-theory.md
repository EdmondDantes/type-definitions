# General statement of the problem for remote procedure calls

## Problem

The problem is to implement a remote procedure call (`RPC`) system that allows a `client` to call 
a `function` on a `server` as if it were a local function call. 

The `client` should be able to pass arguments to the function and receive the return value from the function. 

Both the `client` and the `server` are aware of the function `call specification`, 
which they need to correctly marshal data over the network.

The `client` and `server` usually use the `function name` or the `service and function name` to find the call specification.
Sometimes a flexible call specification is necessary, which is based on other criteria.

The `data types` of the arguments\return value should be such that they are easily implementable in different programming languages.

The `client` and `server` should be able to handle `errors` that occur during the `RPC` call.

## Features of PHP and useful constraints

`PHP` supports a highly flexible set of data types for passing arguments and return values. 
This makes it less convenient compared to other programming languages. 
Therefore, it is wise NOT to use all of PHP's capabilities when constructing remote procedures.

However, it would be unwise to completely block the possibility of remote calls between PHP components. 
Therefore, we adhere to the philosophy of avoiding PHP features that are difficult to serialize in other languages.

