import { Link, usePage } from "@inertiajs/react";
import { Home, Users, FileText, Settings } from "lucide-react";

const Sidebar = () => {
  const { url } = usePage(); // current active URL from Inertia

  const menu = [
    { name: "Dashboard", path: "/dashboard", icon: <Home size={20} /> },
    { name: "Customers", path: "/customers", icon: <Users size={20} /> },
    { name: "Invoices", path: "/invoices", icon: <FileText size={20} /> },
    { name: "Settings", path: "/settings", icon: <Settings size={20} /> },
  ];

  return (
    <aside className="w-64 h-screen bg-gray-900 text-gray-100 flex flex-col shadow-lg">
      <div className="p-6 text-2xl font-bold border-b border-gray-700">SmartFlowPro</div>
      <nav className="flex-1 p-4 space-y-2">
        {menu.map((item) => (
          <Link
            key={item.name}
            href={item.path}
            className={`transition-color group flex cursor-pointer items-center gap-x-base p-small text-base leading-base text-heading duration-base focus:outline-0 rounded-base data-[status=active]:font-bold data-[status=active]:bg-surface data-[status=active]:hover:bg-surface poi:bg-surface--background--hover active
              ${url.startsWith(item.path) ? "bg-blue-600 text-white" : "hover:bg-gray-800"}`}
          >
            {item.icon}
            {item.name}
          </Link>
        ))}
      </nav>
    </aside>
  );
};

<style>{`
  .sidebar {
    background: #000 !important;
  }
`}</style>
export default Sidebar;
