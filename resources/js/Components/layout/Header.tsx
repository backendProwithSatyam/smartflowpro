import { useState } from "react";
import { router } from "@inertiajs/react";
import { UserCircle } from "lucide-react";

const Header = () => {
  const [open, setOpen] = useState(false);

  const handleLogout = () => {
    router.post("/logout");
  };

  return (
    <header className="h-16 bg-white shadow flex items-center justify-between px-6 relative">
      <h1 className="text-xl font-semibold text-gray-800">Dashboard</h1>

      <div className="relative">
        {/* Profile Icon */}
        <button
          onClick={() => setOpen((prev) => !prev)}
          className="focus:outline-none"
        >
          <UserCircle size={32} className="text-gray-700 cursor-pointer" />
        </button>

        {/* Dropdown */}
        {open && (
          <div className="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-xl shadow-lg">
            <button
              onClick={handleLogout}
              className="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-xl"
            >
              Logout
            </button>
          </div>
        )}
      </div>
    </header>
  );
};

export default Header;
