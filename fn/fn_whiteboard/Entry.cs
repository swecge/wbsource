using Azure.Core;
using Azure.Identity;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Azure.Functions.Worker;
using Microsoft.Extensions.Logging;

namespace fn_whiteboard
{
    public class Entry
    {
        private readonly ILogger<Entry> _logger;

        public Entry(ILogger<Entry> logger)
        {
            _logger = logger;
        }

        [Function("GetToken")]
        public IActionResult Run([HttpTrigger(AuthorizationLevel.Function, "get")] HttpRequest req)
        {
            _logger.LogInformation("GetToken function processed a request.");
            var tokenCredential = new DefaultAzureCredential();
            var accessToken = tokenCredential.GetToken(new TokenRequestContext(scopes: new[] { "https://management.azure.com/.default" }));
            return new OkObjectResult(accessToken.Token);
        }
    }
}
