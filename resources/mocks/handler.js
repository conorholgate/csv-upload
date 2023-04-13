import { afterAll, afterEach, beforeAll } from "vitest";
import { setupServer } from "msw/node";
import { rest } from "msw";

export const people = [
    { title: "Mr", initial: null, first_name: "Conor", last_name: "Holgate" },
    { title: "Mr", initial: null, first_name: "Conor", last_name: "Holgate" },
    { title: "Mr", initial: null, first_name: "Conor", last_name: "Holgate" },
    { title: "Mr", initial: null, first_name: "Conor", last_name: "Holgate" },
];

export const restHandlers = [
    rest.post("http://localhost:8000/", (req, res, ctx) => {
        return res(ctx.status(200), ctx.json(people));
    }),
];

const server = setupServer(...restHandlers);

// Start server before all tests
beforeAll(() => server.listen({ onUnhandledRequest: "error" }));

//  Close server after all tests
afterAll(() => server.close());

// Reset handlers after each test `important for test isolation`
afterEach(() => server.resetHandlers());
